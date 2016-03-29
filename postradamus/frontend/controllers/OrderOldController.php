<?php

namespace frontend\controllers;

use common\components\PaypalIpn;
use frontend\models\cTransaction;
use frontend\models\cTransactionNew;
use frontend\models\SignupForm;
use common\models\cUser;
use common\models\cTransactionNewest;
use backend\components\Common;
use Yii;

class OrderOldController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionAdvanced()
    {
        echo $this->renderPartial('buypage');
    }

    public function actionBeta()
    {
        echo $this->renderPartial('beta');
    }

    public function determineInfo($transaction)
    {

        //perform a lookup first
        $user_exists = cUser::find()->where('paypal_email = "' . $transaction->Payer . '" OR email = "' . $transaction->Payer . '"')->count();
        if($user_exists == 1)
        {
            $site = 'www.1s0s.com';
            $label = 'Postradamus';
            return [$site, $label];
        }

        //see if we have any other transactions with same $transaction->Payer
        if($transaction->Payer != null)
        {
            $prev_trans = \common\models\SaFinancesTransactions::find()->where('Description LIKE "%' . $transaction->Payer . '%" AND Site != "" AND Label != ""')->one();
            if(count($prev_trans) == 1)
            {
                $site = $prev_trans->Site;
                $label = $prev_trans->Label;
                return [$site, $label];
            }
        }

        //try doing a string match
        $matches = [
            'postradamus' => ['www.1s0s.com', 'Postradamus'],
            'jvzoo' => ['www.1s0s.com', 'Postradamus'],
            'instapost' => ['www.1s0s.com', 'Postradamus'],
            'rutecky' => ['www.1s0s.com', 'Postradamus'],
            'github' => ['', 'Github'],
        ];
        foreach($matches as $match => $info)
        {
            if(stristr(serialize($transaction), $match))
            {
                return [$info[0], $info[1]];
            }
        }

        //small transaction = postradamus trial
        $amount = (isset($transaction->NetAmount) ? $transaction->NetAmount->value : '');
        if($amount != '' && $amount < 1 && $amount > 0)
        {
            $site = 'www.1s0s.com';
            $label = 'Postradamus';
            return [$site, $label];
        }

        return ['',''];
    }

    public function actionPaypalImportAll()
    {
        ob_start();

        if(YII_ENV == 'dev')
        {
            require_once('c:/xampp/htdocs/postradamus/vendor/paypal/merchant-sdk-php/samples/PPBootStrap.php');
        }
        else
        {
            require_once('/home/allblogs/botpostfb3/vendor/paypal/merchant-sdk-php/samples/PPBootStrap.php');
        }

        $transactionSearchRequest = new \TransactionSearchRequestType();
        //$transactionSearchRequest->StartDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 5, date("Y"))) . 'T00:00:00Z';
        //$transactionSearchRequest->EndDate = date("Y-m-d") . 'T00:00:00Z';

        $transactionSearchRequest->StartDate = $_GET['start'];// . 'T00:00:00Z';
        if(Yii::$app->request->get('end') != '') { $transactionSearchRequest->EndDate = $_GET['end']; }// . 'T00:00:00-0000';
        if(isset($_GET['transactionID'])) { $transactionSearchRequest->TransactionID = $_REQUEST['transactionID']; }

        $tranSearchReq = new \TransactionSearchReq();
        $tranSearchReq->TransactionSearchRequest = $transactionSearchRequest;

        /*
         * 		 ## Creating service wrapper object
         * Creating service wrapper object to make API call and loading
         * Configuration::getAcctAndConfig() returns array that contains credential and config parameters
        */
        $config = \Configuration::getAcctAndConfig();
        $paypalService = new \PayPalAPIInterfaceServiceService($config);
        try {
            /* wrap API method calls on the service object with a try catch */
            $transactionSearchResponse = $paypalService->TransactionSearch($tranSearchReq);
            //\yii\helpers\VarDumper::dump($transactionSearchResponse, 10, true);
            echo "counted " . count($transactionSearchResponse->PaymentTransactions) . '<br />';
        } catch (Exception $ex) {
            //include_once("../Error.php");
            //exit;
        }
        error_reporting(0);
        $transs = [];
        $transactions = '';
        $lastDate = '';
        $fees = [];
        $i=0;

        if(isset($transactionSearchResponse)) {
            if(isset($transactionSearchResponse->PaymentTransactions) && !empty($transactionSearchResponse->PaymentTransactions))
            {
                //$transactionSearchResponse->PaymentTransactions = array_reverse($transactionSearchResponse->PaymentTransactions);

                foreach($transactionSearchResponse->PaymentTransactions as $transaction)
                {
                    $i++;
                    if($i == 1 && Yii::$app->request->get('end') != '')
                    {
                        continue;
                    }
                    if($transaction->PayerDisplayName == 'Bank Account')
                    {
                        continue;
                    }

                    //print("<pre>");
                    //print_r($transaction);
                    //print("</pre>");
                    $amount = (isset($transaction->GrossAmount) ? $transaction->GrossAmount->value : '');
                    if($amount > 0) { $category = 'Payment'; } else { $category = 'Cost'; }
                    $fee = ((isset($transaction->FeeAmount) && $transaction->FeeAmount->value != '0.00') ? $transaction->FeeAmount->value : '');
                    if($amount != '')
                    {
                        //handle 1s0s.com
                        //\yii\helpers\VarDumper::dump($transaction, 10, true);

                        $info = $this->determineInfo($transaction);
                        $site = $info[0];
                        $label = $info[1];

                        if($transaction->Type != 'Fee Reversal' && $transaction->Type != 'Temporary Hold' && $transaction->Type != 'Authorization')
                        {
                            $date = new \DateTime($transaction->Timestamp);
                            $date->setTimezone(new \DateTimeZone('America/Los_Angeles'));
                            $sql = "
                                INSERT INTO savingadviceOLD.sa_finances_transactions
                                SET Category = '$category', Label = '" . $label . "',
                                Description = '" . addslashes(serialize($transaction)) . "', Site = '$site',
                                Amount = '$amount',
                                `Date` = '" . $date->format("Y-m-d") . "'
                            ";
                            $lastDate = $transaction->Timestamp;
                            if(Yii::$app->request->get('show_sql') == 1) {
                                echo $sql . ';<br />';
                            }
                            $transs[$date->format("Y-m-d")]++;

                            if(Yii::$app->request->get('show_transactions') == 1) {
                                $transactions .= "<tr>";
                                $transactions .= "<td><b>" . $date->format("Y-m-d H:i") . "</b></td>";
                                $transactions .= "<td><b>" . $transaction->Timestamp . "</b></td>";
                                $transactions .= "<td>" . $transaction->PayerDisplayName . "</td>";
                                $transactions .= "<td>" . $transaction->NetAmount->value . "</td>";
                                $transactions .= "<td>" . $site . "(" . $label . ")" . "</td>";
                                $transactions .= "</tr>";
                            }

                            if($fee != '')
                            {
                                if($fee > 0) { $category = 'Payment'; } else { $category = 'Cost'; }
                                $sql2 = "
                                INSERT INTO savingadviceOLD.sa_finances_transactions
                                SET Category = '$category', Label = 'Paypal', Site = '$site',
                                Description = '" . addslashes(serialize($transaction)) . "',
                                Amount = '" . $fee . "',
                                `Date` = '" . $date->format("Y-m-d") . "'
                            ";
                                if(Yii::$app->request->get('show_sql') == 1) {
                                    echo $sql2 . ';<br />';
                                }
                                $transs[$date->format("Y-m-d")]++;
                            }
                        }
                    }
                }
            }

            sleep(1);
            set_time_limit(30);

            echo "<table style='font-family:tahoma; font-size:90%' cellpadding='5'>";
            echo $transactions;
            echo "</table>";
            $url = Yii::$app->urlManager->createUrl(['order-old/paypal-import-all', 'show_transactions' => Yii::$app->request->get('show_transactions'), 'show_sql' => Yii::$app->request->get('show_sql'), 'start' => Yii::$app->request->get('start'), 'end' => $lastDate]);
            //echo "<meta http-equiv='refresh' content='2;URL=$url'>";
            echo "<a href='" . $url . "'>Next Page</a>";
        }
        $c = ob_get_clean();
        echo $c;
        mail("natesanden@gmail.com", "Paypal SQL", $c);
    }

    public function actionPaypalImport()
    {
        if(Yii::$app->user->id == 1)
        {
            require_once('/home/postradam/files/vendor/paypal/merchant-sdk-php/samples/PPBootStrap.php');

            $users = cUser::find(['status' => 10])->all();
            foreach($users as $user)
            {
                echo $user->paypal_email;

                if($user->paypal_email != '')
                {

                    $transactionSearchRequest = new \TransactionSearchRequestType();
                    $transactionSearchRequest->StartDate = '2014-01-24T00:00:00-0700';
                    $transactionSearchRequest->EndDate = '2014-11-09T00:00:00-0700';
                    $transactionSearchRequest->Payer = $user->paypal_email;
                    //$transactionSearchRequest->TransactionID = $_REQUEST['transactionID'];

                    $tranSearchReq = new \TransactionSearchReq();
                    $tranSearchReq->TransactionSearchRequest = $transactionSearchRequest;

                    /*
                     * 		 ## Creating service wrapper object
                    Creating service wrapper object to make API call and loading
                    Configuration::getAcctAndConfig() returns array that contains credential and config parameters
                    */
                    $paypalService = new \PayPalAPIInterfaceServiceService(\Configuration::getAcctAndConfig());
                    try {
                        /* wrap API method calls on the service object with a try catch */
                        $transactionSearchResponse = $paypalService->TransactionSearch($tranSearchReq);
                    } catch (Exception $ex) {
                        //include_once("../Error.php");
                        //exit;
                    }
                    if(isset($transactionSearchResponse)) {
                        echo "<table>";
                        echo "<tr><td>Ack :</td><td><div id='Ack'>$transactionSearchResponse->Ack</div> </td></tr>";
                        echo "</table>";
                        echo "<pre>";
                        print_r($transactionSearchResponse);
                        echo "</pre>";


                        if(isset($transactionSearchResponse->PaymentTransactions) && !empty($transactionSearchResponse->PaymentTransactions))
                        {
                            foreach($transactionSearchResponse->PaymentTransactions as $transaction)
                            {
                                $new_transaction = new cTransactionNewest;
                                $new_transaction->user_id = $user->id;
                                $new_transaction->type = $transaction->Type;
                                $new_transaction->amount = (isset($transaction->GrossAmount) ? $transaction->GrossAmount->value : 0);
                                $new_transaction->fee = (isset($transaction->FeeAmount) ? $transaction->FeeAmount->value : 0);
                                $new_transaction->net = (isset($transaction->NetAmount) ? $transaction->NetAmount->value : 0);
                                $new_transaction->details = serialize($transaction);
                                $new_transaction->created = strtotime($transaction->Timestamp);
                                $new_transaction->save(false);
                            }
                        }

                        sleep(1);
                        set_time_limit(30);

                    }

                }

            }
        }
        //require_once '../Response.php';
    }

    public function actionIpn()
    {
        $listener = new PaypalIpn();
        $listener->force_ssl_v3 = false;
        $listener->use_sandbox = false;

        try {
            $verified = $listener->processIpn();
        } catch (\Exception $e) {
            // fatal error trying to process IPN.
            mail("natesanden@gmail.com", "Paypal IPN Exception", $e->getMessage(), "FROM: Postradamus <info@1s0s.com>");
            exit(0);
        }

        if ((isset($verified) && $verified == true)) { //ipn was valid

            // Payment has been recieved and IPN is verified.  This is where you
            // update your database to activate or process the order, or setup
            // the database with the user's order details, email an administrator,
            // etc.  You can access a slew of information via the ipn_data() array.

            // Check the paypal documentation for specifics on what information
            // is available in the IPN POST variables.  Basically, all the POST vars
            // which paypal sends, which we send back for validation, are now stored
            // in the ipn_data() array.

            // For this example, we'll just email ourselves ALL the data.

            //mail it
            $subject = 'Instant Payment Notification: ' . Yii::$app->request->get('txn_type');
            $to = 'natesanden@gmail.com';    //  your email
            $body =  "An instant payment notification was successfully recieved\n";
            $body .= " at ".date('g:i A')."\n\nDetails:\n";
            foreach($_POST as $k => $v)
            {
                $body .= $k . ": " . $v . "\n";
            }
            mail($to, $subject, $body, "FROM: Postradamus <info@1s0s.com>");

            //db insert
            try {
                $site = '';
                $label = '';
                //handle 1s0s.com
                if(stristr(Yii::$app->request->post('invoice'), 'postradamus') && !stristr(Yii::$app->request->post('invoice'), 'jvzoo'))
                {
                    $site = 'www.1s0s.com';
                    $label = 'Postradamus';
                }
                $user_exists = cUser::find()->where(['paypal_email' => $_POST['payer_email']])->count();
                if($user_exists == 1)
                {
                    $site = 'www.1s0s.com';
                    $label = 'Postradamus';
                }
                $user_exists = cUser::find()->where(['email' => $_POST['payer_email']])->count();
                if($user_exists == 1)
                {
                    $site = 'www.1s0s.com';
                    $label = 'Postradamus';
                }

                $sql = ''; $sql2 = '';
                $amount = (isset($_POST['mc_amount3']) ? $_POST['mc_amount3'] : (isset($_POST['mc_gross']) ? $_POST['mc_gross'] : ''));
                if($amount > 0) { $category = 'Payment'; } else { $category = 'Cost'; }
                if($amount != '')
                {
                    $sql = "
                        INSERT INTO savingadviceOLD.sa_finances_transactions
                        SET Category = '$category', Label = '$label',
                        Description = '" . addslashes($listener->getTextReport()) . "', Site = '$site',
                        Amount = '$amount',
                        Date = '" . date("Y-m-d") . "'
                    ";
                }
                $fee = ((isset($_POST['payment_fee']) && $_POST['payment_fee'] != '0.00') ? $_POST['payment_fee'] : '') * -1;
                if($fee != '') {
                    if($fee > 0) { $category = 'Payment'; } else { $category = 'Cost'; }
                    $sql2 = "
                        INSERT INTO savingadviceOLD.sa_finances_transactions
                        SET Category = '$category', Label = 'Paypal', Site = '$site',
                        Amount = '" . $fee . "',
                        Date = '" . date("Y-m-d") . "'
                    ";
                }
                mail($to, 'SQL FOR SA FINANCES', $sql . $sql2, "FROM: Postradamus <info@1s0s.com>");

                $trans = new cTransaction;
                $trans->id = (isset($_POST['subscr_id']) ? $_POST['subscr_id'] : $_POST['txn_id']);
                $trans->first_name = $_POST['first_name'];
                $trans->last_name = $_POST['last_name'];
                $trans->email_address = $_POST['payer_email'];
                $trans->amount = (isset($_POST['mc_amount3']) ? $_POST['mc_amount3'] : (isset($_POST['mc_gross']) ? $_POST['mc_gross'] : 0));
                $trans->ipn_data = $listener->getTextReport();
                $trans->payment_status = (isset($_POST['payment_status']) ? $_POST['payment_status'] : '');
                $trans->save(false);
            }
            catch(\Exception $e)
            {
                mail('natesanden@gmail.com', 'Exception during Tranasaction create', $e->getMessage(), "FROM: Postradamus <info@1s0s.com>");
            }

            if(Yii::$app->request->post('txn_type') == 'subscr_signup' && strstr(Yii::$app->request->post('invoice'), 'Postradamus'))
            {
                try {
                    //create an account
                    $model = new SignupForm();
                    //get our custom field
                    //$custom = unserialize($_POST['custom']); //should contain at least $custom['plan_id']
                    //$email = (isset($custom['email']) ? $custom['email'] : $_POST['payer_email']);
                    $email = (isset($_POST['custom']) ? $_POST['custom'] : $_POST['payer_email']);
                    $model->username = $email; //email is entered through our lead page
                    $model->password = Common::generatePassword(); //paypal generated
                    $model->email = $email; //email is entered through our lead page
                    $model->paypal_email = $_POST['payer_email'];
                    $model->first_name = (isset($_POST['first_name']) ? $_POST['first_name'] : '');
                    $model->last_name = (isset($_POST['last_name']) ? $_POST['last_name'] : '');
                    $model->paypal_subscription_id = $_POST['subscr_id'];
                    $model->plan_id = 3; //always available either through lead page or just plain button
                    $newuser = $model->signup();
                    if(isset($newuser) && !empty($newuser))
                    {
                        //mail it
                        $subject = 'New User Created';
                        $to = 'natesanden@gmail.com,jeffrey@savingadvice.com';    //  your email
                        $body =  "A user (".$model->username.") was automatically created\n";
                        $body .= "from paypal: ".$_POST['payer_email']." on ".date('m/d/Y');
                        mail($to, $subject, $body, "FROM: Postradamus <info@1s0s.com>");

                        //email customer his account details
                        $subject = 'Thank you for your order';
                        $to = $email;
                        $body = $this->renderPartial('_email_thank_you_for_ordering', ['model' => $model]);
                        mail($to, $subject, $body, "FROM: Postradamus <info@1s0s.com>");
                    }
                    else
                    {
                        //mail it
                        $subject = 'New User Could NOT Be Created';
                        $to = 'natesanden@gmail.com';    //  your email
                        $body =  "We tried to create this user but...\n";
                        //$body .= serialize($newuser->getErrors());
                        mail($to, $subject, $body, "FROM: Postradamus <info@1s0s.com>");
                    }
                } catch(\Exception $e) {
                    //hoping to catch db error here
                    mail('natesanden@gmail.com', 'Exception during subscr_signup - ', $e->getMessage(), "FROM: Postradamus <info@1s0s.com>");
                }
            }

            if(Yii::$app->request->post('txn_type') == 'cart' && strstr(Yii::$app->request->post('invoice'), 'InstaPost'))
            {
                try {
                    //create an account
                    $model = new SignupForm();
                    //get our custom field
                    //$custom = unserialize($_POST['custom']); //should contain at least $custom['plan_id']
                    //$email = (isset($custom['email']) ? $custom['email'] : $_POST['payer_email']);
                    $email = $_POST['payer_email'];
                    $model->username = $email; //email is entered through our lead page
                    $model->password = Common::generatePassword(); //paypal generated
                    $model->email = $email; //email is entered through our lead page
                    $model->paypal_email = $_POST['payer_email'];
                    $model->first_name = (isset($_POST['first_name']) ? $_POST['first_name'] : '');
                    $model->last_name = (isset($_POST['last_name']) ? $_POST['last_name'] : '');

                    $model->plan_id = 0;

                    $newuser = $model->signup();
                    if($newuser)
                    {
                        $already_registered = false;
                    }
                    else
                    {
                        $already_registered = true;
                    }

                    //mail it
                    $subject = 'New User Created';
                    $to = 'natesanden@gmail.com,jeffrey@savingadvice.com';    //  your email
                    $body =  "A user (".$model->username.") was automatically created\n";
                    $body .= "from paypal: ".$_POST['payer_email']." on ".date('m/d/Y');
                    mail($to, $subject, $body, "FROM: InstaPost <info@1s0s.com>");

                    //email customer his account details
                    $subject = 'Thank you for your order';
                    $to = $email;
                    $body = $this->renderPartial('_email_thank_you_for_ordering_instapost', ['model' => $model, 'already_registered' => $already_registered]);
                    mail($to, $subject, $body, "FROM: InstaPost <info@1s0s.com>");

                } catch(\Exception $e) {
                    //hoping to catch db error here
                    mail('natesanden@gmail.com', 'Exception during subscr_signup - ', $e->getMessage(), "FROM: InstaPost <info@1s0s.com>");
                }
            }

            //jvzoo
            if(Yii::$app->request->post('txn_type') == 'web_accept' && strstr(Yii::$app->request->post('invoice'), 'Postradamus'))
            {
                try {
                    //create an account
                    $model = new SignupForm();
                    //get our custom field
                    //$custom = unserialize($_POST['custom']); //should contain at least $custom['plan_id']
                    //$email = (isset($custom['email']) ? $custom['email'] : $_POST['payer_email']);
                    $email = $_POST['payer_email'];
                    $model->username = $email; //email is entered through our lead page
                    $model->password = Common::generatePassword(); //paypal generated
                    $model->email = $email; //email is entered through our lead page
                    $model->paypal_email = $_POST['payer_email'];
                    $model->first_name = (isset($_POST['first_name']) ? $_POST['first_name'] : '');
                    $model->last_name = (isset($_POST['last_name']) ? $_POST['last_name'] : '');
                    $model->paypal_subscription_id = $_POST['txn_id'];

                    if(strstr(Yii::$app->request->post('invoice'), 'Facebook Page Scheduler and Viral Content Curator'))
                        $model->plan_id = 1; //always available either through lead page or just plain button

                    if(strstr(Yii::$app->request->post('invoice'), 'Facebook Page Scheduler and Viral Content Curator - Advanced Package'))
                        $model->plan_id = 2; //always available either through lead page or just plain button

                    if(strstr(Yii::$app->request->post('invoice'), 'Facebook Page Scheduler and Viral Content Curator - Unlimited Package'))
                        $model->plan_id = 3; //always available either through lead page or just plain button

                    $newuser = $model->signup();
                    if(isset($newuser) && !empty($newuser))
                    {
                        //mail it
                        $subject = 'New User Created';
                        $to = 'natesanden@gmail.com,jeffrey@savingadvice.com';    //  your email
                        $body =  "A user (".$model->username.") was automatically created\n";
                        $body .= "from paypal: ".$_POST['payer_email']." on ".date('m/d/Y');
                        mail($to, $subject, $body, "FROM: Postradamus <info@1s0s.com>");

                        //email customer his account details
                        $subject = 'Thank you for your order';
                        $to = $email;
                        $body = $this->renderPartial('_email_thank_you_for_ordering', ['model' => $model]);
                        mail($to, $subject, $body, "FROM: Postradamus <info@1s0s.com>");
                    }
                    else
                    {
                        //mail it
                        $subject = 'New User Could NOT Be Created';
                        $to = 'natesanden@gmail.com';    //  your email
                        $body =  "We tried to create this user but...\n";
                        //$body .= serialize($newuser->getErrors());
                        mail($to, $subject, $body, "FROM: Postradamus <info@1s0s.com>");
                    }
                } catch(\Exception $e) {
                    //hoping to catch db error here
                    mail('natesanden@gmail.com', 'Exception during subscr_signup - ', $e->getMessage(), "FROM: Postradamus <info@1s0s.com>");
                }
            }

            /*
            if(Yii::$app->request->get('txn_type') == 'subscr_cancel')
            {
                try {
                    //email us a warning about it
                    $subject = 'User Cancelled Subscription';
                    $to = 'natesanden@gmail.com';    //  your email
                    $body =  "User cancelled his subscription...\n";
                    $body .= 'We set his end date to ' . $_POST['subscr_date'];
                    mail($to, $subject, $body, "FROM: Postradamus <info@1s0s.com>");
                    //email them sorry to see you go
                    //TO DO TO DO TO DO TO DO

                    //mark their end date on their account
                    $u = cUser::find()->where(['paypal_email' => $_POST['payer_email']])->one();
                    $u->subscription_end_date = $_POST['subscr_date'];
                    $u->save(false);
                } catch(\Exception $e) {
                    //hoping to catch db error here
                    mail('natesanden@gmail.com', 'Exception during cancellation IPN', $e->getMessage(), "FROM: Postradamus <info@1s0s.com>");
                }
            }
            */
            if(Yii::$app->request->post('txn_type') == 'subscr_eot')
            {
                //at this point we've already bugged the user a few times to try and get him to renew. dont bug him again.

                try {
                    //email us a warning about it
                    $subject = 'User Subscription Term Ended';
                    $to = 'natesanden@gmail.com';    //  your email
                    $body =  "This users subscription has reached end of term...\n";
                    $body .= 'We set his end date to today';
                    mail($to, $subject, $body, "FROM: Postradamus <info@1s0s.com>");
                    //email them sorry to see you go
                    $u = cUser::find()->where(['paypal_email' => $_POST['payer_email']]);
                    $u->subscription_end_date = date("Y-m-d");
                    $u->status = 0;
                    $u->save(false);
                } catch(\Exception $e) {
                    //hoping to catch db error here
                    mail('natesanden@gmail.com', 'Exception during subscr_eot - ', $e->getMessage(), "FROM: Postradamus <info@1s0s.com>");
                }
            }

        }
        else
        {
            mail("natesanden@gmail.com", "IPN was not verified", "IPN was not verified", "FROM: Postradamus <info@1s0s.com>");
        }
    }

    public function actionCancel()
    {
        echo "Cancel!!!";
    }

    /* Subscription created and paypal redirected user back to this page */
    /* Not sure if we have variables here except for $_POST[txn_id] */
    public function actionSuccess()
    {
        //see if the tbl_transaction is completed
        //create account if so and redirect them to postradamus
        echo "Success!!!";
    }
}