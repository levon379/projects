<?php
namespace backend\controllers;

use Yii;
use common\models\cUser;

/**
 * Site controller
 */
class OrderController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionGetActiveAccounts()
    {
        echo "plan 1 " . ($plan1 = cUser::find()->where(['status' => 10, 'beta' => 0])->andWhere('plan_id = 1')->count()) . " $" . ($plan1 * 27) . "<br />";
        echo "plan 2 " . ($plan2 = cUser::find()->where(['status' => 10, 'beta' => 0])->andWhere('plan_id = 2')->count()) . " $" . ($plan2 * 47) . "<br />";
        echo "plan 3 " . ($plan3 = cUser::find()->where(['status' => 10, 'beta' => 0])->andWhere('plan_id = 3')->count()) . " $" . ($plan3 * 97) . "<br />";
        echo "plan 4 " . ($plan4 = cUser::find()->where(['status' => 10, 'beta' => 0])->andWhere('plan_id = 4')->count()) . " $" . ($plan4 * (662 / 12)) . "<br />";
    }

    public function actionTestEndingDate($user_id)
    {
        $order = new \common\components\Order;
        $jvzoo = new \common\components\JvzooRest;
        \yii\helpers\VarDumper::dump($order->getEndingDate(json_decode($jvzoo->getRecurringPayment('PA-' . $order->getLastTransactionReceiptNo($user_id)))), 10, true);
    }

    public function actionTestRefundAmount($user_id)
    {
        $u = cUser::findOne($user_id);
        $order = new \common\components\Order;
        \yii\helpers\VarDumper::dump($order->getRefundAmount($user_id), 10, true);
    }

    public function actionJvzIpn()
    {
        try {
            $order = new \common\components\Order;
            $jvzooIpn = new \common\components\JvzooIpn;
            if($jvzooIpn->verifyIpn() || YII_ENV == 'test')
            {
                /*
                 * Step 1 - Determine if user account exists yet for post('ccustemail')
                 *      Account Exists
                 *
                 *      Account No Exists
                 *          Create Account
                */
                $u = cUser::find()->where(['email' => Yii::$app->request->post('ccustemail')])->one();

                $scenario_complete = false;
                $plan_id = $order->getPlan(Yii::$app->request->post('cproditem'));

                //scenario 1 - FIRST TIME PURCHASE
                if(
                    Yii::$app->request->post('ctransaction') == 'SALE' &&
                    empty($u)
                )
                {
                    $order->createAccount(Yii::$app->request->post('ccustemail'), Yii::$app->request->post('ccustname'), Yii::$app->request->post('ccustname'), $plan_id);
                    $scenario_complete = true;
                }

                //scenario 2 - UPGRADE / DOWNGRADE / REPURCHASE / PAYMENT
                if(
                    $scenario_complete == false &&
                    (Yii::$app->request->post('ctransaction') == 'SALE' || Yii::$app->request->post('ctransaction') == 'BILL') &&
                    !empty($u)
                )
                {
                    $params = ['plan_id' => $plan_id];
                    $order->modifyAccount($u, $params);
                    $scenario_complete = true;
                }

                //scenario 3 - CANCEL
                if(
                    $scenario_complete == false &&
                    (Yii::$app->request->post('ctransaction') == 'CANCEL-REBILL' || Yii::$app->request->post('ctransaction') == 'RFND') &&
                    !empty($u)
                )
                {
                    $order->logAccountAction($u->id, 'Account Cancelled');
                    //IF cproditem matches $u->role (users last purchased product)
                    //AND we can find a SALE or BILL for same cproditem
                    //   (SELECT created_at FROM jvz_ipn_log WHERE (ctransaction = SALE OR ctransaction = BILL) AND cproditem = cproditem AND user_id = $u->id)
                    //THEN set user.cancel_effective_date =
                }

                if($scenario_complete == false)
                {
                    //we need to know about it.

                }

                //log the jvz_ipn
                $order->logJvzIpn(1);
            }
            else
            {
                echo "Failed verification";

                //log the jvz_ipn
                $order->logJvzIpn(0);
            }
            //lets echo out the special instructions which show up in uh jvzoo        }
        }
        catch(\Exception $e)
        {
            ob_start();
            \yii\helpers\VarDumper::dump($e, 10, true);
            $d = ob_get_clean();
            mail("natesanden@gmail.com", "super important errors", $d);
        }
    }

    public function actionAccess()
    {
        //lets see if we can find the user's account
        $u = cUser::find()->where(['email' => Yii::$app->request->get('cemail'), 'status' => 10])->one();
        if(!empty($u))
        {
            $msg = "<p><b>Thanks for choosing " . Yii::$app->name . "!</b></p>";
            $msg .= "<p>Your account is now ready and you can login below.</p>";
            $msg .= "<p>Your username is your email (<b>" . Yii::$app->request->get('cemail') . "</b>) and your <b>password</b> was sent to you via email when you signed up.</p>";
            $msg .= "<p>If you can't find your password and would like to reset it, just <a href='".Yii::$app->urlManager->createUrl(['site/request-password-reset'])."'>click here</a>.</p>";
            Yii::$app->session->setFlash('success', $msg);
            $this->redirect(['site/index']);
            //$this->render('access');
        }
        else
        {
            $msg = "Looks like your account is not yet setup. If you just ordered, please try refreshing this page right now. If you continue seeing this message, please email us at info@1s0s.com";
            Yii::$app->session->setFlash('danger', $msg);
            echo $this->render('access');
        }
    }

    public function actionTestJvzooRest($pre_key)
    {
        $jvzoo = new \common\components\JvzooRest;
        $response = json_decode($jvzoo->getRecurringPayment($pre_key));
        $order = new \common\components\Order;
        echo $order->getAffiliateCommissionPercent($response);
        \yii\helpers\VarDumper::dump($response, 10, true);
    }

}