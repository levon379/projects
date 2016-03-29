<?php
/**
 * Created by PhpStorm.
 * User: Nate
 * Date: 1/15/2015
 * Time: 4:09 PM
 */

namespace common\components;

use common\models\cUserTransaction;
use Yii;
use common\models\cPlan;

class Order {

    public function getRefundAmount($user_id)
    {
        $ut = cUserTransaction::find()->where(['user_id' => $user_id])->andWhere('type = "SALE" OR type="BILL"')->orderBy('created_at DESC')->one();
        if(isset($ut))
        {
            $ipn = json_decode($ut->ipn);
            $days_on_plan = ceil(abs($ut->created_at - time())/60/60/24);
            $price_per_day = $ipn->ctransamount / 30;
            $owed = $days_on_plan * $price_per_day;
            $paid = $ipn->ctransamount;
            $refund = $paid - $owed;
            return number_format(round($refund, 2), 2);
        }
        return false;
    }

    public function isAffiliateOwned($recurring_payment)
    {
        if($recurring_payment->results[0]->payment_trial_payout != 0)
        {
            return true;
        }
        return false;
    }

    public function getAffiliateCommissionPercent($recurring_payment)
    {
        if($recurring_payment->results[0]->payment_trial_payout != 0)
        {
            $payout = $recurring_payment->results[0]->payment_trial_payout;
            $price = $recurring_payment->results[0]->payment_trial_price;
            //calculate how much % of $payout the $price is
            $diff = $price - $payout;
            $percentage = ($diff / $price) * 100;
            return $percentage;
        }
        return false;
    }

    public function getEndingDate($recurring_payment)
    {
        if($recurring_payment->results[0]->next_date)
        {
            return date("Y-m-d", strtotime($recurring_payment->results[0]->next_date) + 86400);
        }
        return false;
    }

    /* IS THIS EVEN USED??? */
    public function getLatestUserTransactionPreKey($user_id)
    {
        $ut = cUserTransaction::find()->where(['user_id' => $user_id])->orderBy('created_at DESC')->one();
        if(isset($ut))
        {
            $ipn = json_decode($ut->ipn);
            //could be a dash in the receipt no, get rid of that
            $receipt_no = explode("-", $ipn->ctransreceipt);
            return $receipt_no[0];
        }
        return false;
    }

    public function getLastTransactionReceiptNo($user_id)
    {
        $ut = cUserTransaction::find()->where(['user_id' => $user_id])->andWhere('type = "SALE" OR type="BILL"')->orderBy('created_at DESC')->one();
        if(isset($ut))
        {
            $ipn = json_decode($ut->ipn);
            //could be a dash in the receipt no, get rid of that
            $receipt_no = explode("-", $ipn->ctransreceipt);
            return $receipt_no[0];
        }
        //nothing returned, try our data entry one
        $u = \common\models\cUser::findOne($user_id);
        if($u->jvzoo_pre_key != '')
        {
            return str_replace("PA-", "", $u->jvzoo_pre_key);
        }
        return false;
    }
    public function modifyAccount($u, $modifications = [])
    {
        //1 upgrade plan
        if(isset($modifications['plan_id']) && $modifications['plan_id'] > $u->plan_id)
        {
            $u->status = 10;
            $u->plan_id = $modifications['plan_id'];
            if(YII_ENV != 'test')
            {
                $jvzoo = new \common\components\JvzooRest;
                $jvzoo->cancelRecurringPayment('PA-' . $this->getLastTransactionReceiptNo($u->id));
            }
            $this->logAccountAction($u->id, 'Account Upgraded');
            $this->emailUser(Yii::$app->name . ': Account Upgraded', ['model' => $u] , '/order/email/user/_account_upgraded');
            $this->emailAdmin(Yii::$app->name . ': Account Upgraded', ['model' => $u, 'refund' => $this->getRefundAmount($u->id)], '/order/email/admin/_account_upgraded');
            $modified = 1;
        }
        //2 downgrade plan
        if(isset($modifications['plan_id']) && $modifications['plan_id'] < $u->plan_id)
        {
            $u->status = 10;
            $u->plan_id = $modifications['plan_id'];
            if(YII_ENV != 'test')
            {
                $jvzoo = new \common\components\JvzooRest;
                $jvzoo->cancelRecurringPayment('PA-' . $this->getLastTransactionReceiptNo($u->id));
            }
            $this->logAccountAction($u->id, 'Account Downgraded');
            $this->emailUser(Yii::$app->name . ': Account Downgraded', ['model' => $u], '/order/email/user/_account_downgraded');
            $this->emailAdmin(Yii::$app->name . ': Account Downgraded', ['model' => $u, 'refund' => $this->getRefundAmount($u->id)], '/order/email/admin/_account_downgraded');
            $modified = 1;
        }
        //re-activate account
        if($u->status != 10) //their account was inactive (probably we de-activated it or script did due to cancellation or non-payment)
        {
            $u->status = 10;
            $this->logAccountAction($u->id, 'Account Re-activated');
            $this->emailUser(Yii::$app->name . ': Account Re-activated', ['model' => $u], '/order/email/user/_account_reactivated');
            $this->emailAdmin(Yii::$app->name . ': Account Re-activated', ['model' => $u, 'refund' => $this->getRefundAmount($u->id)], '/order/email/admin/_account_reactivated');
            $modified = 1;
        }
        //deactivate account
        if(isset($modifications['status']) && $modifications['status'] != 10)
        {
            $u->status = $modifications['status'];
            if(YII_ENV != 'test')
            {
                $jvzoo = new \common\components\JvzooRest;
                $jvzoo->cancelRecurringPayment('PA-' . $this->getLastTransactionReceiptNo($u->id));
            }
            $this->logAccountAction($u->id, 'Account De-activated');
            $this->emailUser(Yii::$app->name . ': Account De-activated', ['model' => $u], '/order/email/user/_account_deactivated');
            $this->emailAdmin(Yii::$app->name . ': Account De-activated', ['model' => $u], '/order/email/admin/_account_deactivated');
            $modified = 1;
        }
        //nothing done so just assume this is a payment
        if(!isset($modified))
        {
            $this->logAccountAction($u->id, 'Payment Received');
            //$this->emailUser($u, Yii::$app->name . ': Payment Received', '/order/email/user/_account_payment_received');
            $this->emailAdmin(Yii::$app->name . ': Payment Received', ['model' => $u, 'amount' => Yii::$app->request->post('ctransamount')], '/order/email/admin/_account_payment');
        }
        else
        {
            $u->save(false);
        }

        return $u;
    }

    public function createAccount($email, $first_name, $last_name, $plan_id)
    {
        $model = new \frontend\models\SignupForm;

        $model->username = $email;
        $model->password = $model::generatePassword();
        $model->email = $email;
        $model->paypal_email = $email;
        $model->first_name = $first_name;
        $model->last_name = $last_name;
        $model->plan_id = $plan_id;

        $u = $model->signup();

        if(isset($u->id))
        {
            $this->logAccountAction($u->id, 'Account Created');
            $this->emailUser(Yii::$app->name . ': Account Created', ['model' => $model], '/order/email/user/_account_created');
            $this->emailAdmin(Yii::$app->name . ': Account Created', ['model' => $model], '/order/email/admin/_account_created');
        }
        else
        {
            $this->emailAdmin(Yii::$app->name . ': Error Creating Account', ['model' => $model], '/order/email/admin/_account_created_error');
        }

        return $u;
    }

    public function emailUser($subject, $data, $body_path)
    {
        $body = $this->render($body_path, $data);
        if(YII_ENV != 'test')
        {
            /*
            Yii::$app->mailer->compose()
                ->setFrom('info@teespy.com')
                ->setTo($data['model']->email)
                ->setSubject($subject)
                ->setTextBody($body)
                ->send();
            */
            mail($data['model']->email, $subject, $body, "FROM: info@1s0s.com");
        }
    }

    public function emailAdmin($subject, $data, $body_path)
    {
        $body = $this->render($body_path, $data);
        if(YII_ENV != 'test')
        {
            /*
            Yii::$app->mailer->compose()
                ->setFrom('info@teespy.com')
                ->setTo(Yii::$app->params['adminEmail'])
                ->setSubject($subject)
                ->setTextBody($body)
                ->send();
            */
            mail('info@1s0s.com', $subject, $body, "FROM: info@1s0s.com");
        }
    }

    public function getPlan($invoice_text)
    {
        //get each jvzoo plan id from our database and apply appropriate role
        $plans = cPlan::find()->where('plan_id != 10')->all();
        //temporary hack for yearly plan
        foreach($plans as $plan)
        {
            $upgrade_plans = explode("|", (string)$plan->jvzoo_product_upgrade_id);
            foreach($upgrade_plans as $upgrade_plan)
            {
                if(stristr($invoice_text, $upgrade_plan) && $upgrade_plan != 0)
                {
                    return $plan->plan_id;
                }
            }
            if(stristr($invoice_text, (string)$plan->jvzoo_product_id))
            {
                return $plan->plan_id;
            }
        }
        return false;
    }

    public function logJvzIpn($valid)
    {
        $jil = new \common\models\cJvzIpnLog;
        $jil->ccustemail = (string)Yii::$app->request->post('ccustemail');
        $jil->cproditem = (string)Yii::$app->request->post('cproditem');
        $jil->ctransaction = (string)Yii::$app->request->post('ctransaction');
        $jil->valid = $valid;
        $jil->post = json_encode(Yii::$app->request->post());
        return $jil->save(false);
    }

    public function logAccountAction($user_id, $action)
    {
        $ua = new \common\models\cUserAction;
        $ua->action = $action;
        $ua->post = (isset($_POST) ? serialize($_POST) : '');
        $ua->get = (isset($_GET) ? serialize($_GET) : '');
        $ua->user_id = $user_id;
        return $ua->save(false);
    }

    function render($view, $data){
        extract($data);
        ob_start();
        include Yii::getAlias('@frontend').'/views'.$view.'.php';
        if(YII_ENV == 'test')
            echo ob_get_clean();
        else
            return ob_get_clean();
    }

}