<?php

use yii\web\HttpException;
use \yii\codeception\DbTestCase;
use \common\components\Order;
use \common\models\cUser;
use \common\models\cUserAction;
use \common\models\cJvzIpnLog;
//use Yii;

class OrderTest extends DbTestCase
{

    public $order;

    public function setUp() {
        parent::setUp();
        $this->order = new Order;

        //setup a test user account
        cUser::deleteAll('id = 99');
        $u = new cUser;
        $u->id = 99;
        $u->username = 'Test';
        $u->first_name = 'Test';
        $u->last_name = 'User';
        $u->password = 'Test';
        $u->email = 'test_email@teespy.com';
        $u->plan_id = 1; //reset the role
        $u->status = 10;
        $u->save(false);
        //delete actions
        //UserAction::deleteAll();
    }

    public function sendJvzIpnPost($params)
    {
        $curl = new \Buzz\Client\Curl;
        set_time_limit(120);
        $curl->setTimeout(120);
        $browser = new \Buzz\Browser($curl);

        // finding account's path
        $url = "http://localhost/postradamus/frontend/web/index-test.php?r=order/jvz-ipn";

        $response = $browser->post($url, [], $params);

        if (200 != $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), 'Couldn\'t get IPN');
        }

        return $response->getContent();
    }

    public function testGetPlan()
    {
        $plan = $this->order->getPlan('This is an invoice');
        $this->assertFalse($plan);
        $plan = $this->order->getPlan('This is an 108695 invoice');
        $this->assertEquals(1, $plan);
        $plan = $this->order->getPlan('This is an 110259 invoice');
        $this->assertEquals(3, $plan);
        $plan = $this->order->getPlan('This is an 110257 invoice');
        $this->assertEquals(2, $plan);
        $plan = $this->order->getPlan('This is an 150340 invoice');
        $this->assertEquals(3, $plan);
        //$plan = $this->order->getPlan('This is an 143128 invoice');
        //$this->assertEquals(4, $plan);
        $plan = $this->order->getPlan('This is an 0 invoice');
        $this->assertEquals(false, $plan);
    }

    public function testActionJvzIpnCreate()
    {
        $email = 'jvzipn_test@teespy.com';
        cUser::deleteAll('email = "' . $email . '"');
        cUserAction::deleteAll();
        cJvzIpnLog::deleteAll();
        //create account
        $params = [
            "caffitid" => "8482583",
            "ccustcc" => "US",
            "ccustemail" => $email,
            "ccustname" => "Nathan Sanden",
            "ccuststate" => "",
            "cproditem" => "108695",
            "cprodtitle" => "Postradamus - Facebook Page Scheduler and Viral Content Curator",
            "cprodtype" => "RECURRING",
            "ctransaction" => "SALE",
            "ctransaffiliate" => "0",
            "ctransamount" => "1.00",
            "ctranspaymentmethod" => "PYPL",
            "ctransreceipt" => "75L056478J0855102",
            "ctranstime" => "1421479488",
            "ctransvendor" => "304399",
            "cupsellreceipt" => '',
            "cvendthru" => "c=TP-SEHWOgin3xe9xuPjmnzx",
            "cverify" => "C444171E"
        ];

        $this->sendJvzIpnPost($params);
        //see if account was created
        $u = cUser::find()->where(['email' => $email])->all();
        //i expect that user is created for first time (and user_action == create account)
        $this->assertCount(1, $u);

        //check user_actions
        $ua = cUserAction::find()->where(['user_id' => $u[0]->id])->all();
        //there should only be one action at this point
        $this->assertCount(1, $ua);
        //it should be 'Account Created'
        $this->assertEquals('Account Created', $ua[0]->action);

        //check ipn log
        $jil = cJvzIpnLog::find()->where(['cproditem' => $params['cproditem']])->all();
        //there should only be one action at this point
        $this->assertCount(1, $jil);
        //it should be 'SALE'
        $this->assertEquals('SALE', $jil[0]->ctransaction);
    }

    public function testActionJvzIpnUpgrade()
    {
        $email = 'jvzipn_test@teespy.com';
        //create account

        $params = [
            "caffitid" => "8482583",
            "ccustcc" => "US",
            "ccustemail" => "jvzipn_test@teespy.com",
            "ccustname" => "Nathan Sanden",
            "ccuststate" => "",
            "cproditem" => "110259",
            "cprodtitle" => "Postradamus - Facebook Page Scheduler and Viral Content Curator - Unlimited Package",
            "cprodtype" => "RECURRING",
            "ctransaction" => "SALE",
            "ctransaffiliate" => "0",
            "ctransamount" => "1.00",
            "ctranspaymentmethod" => "PYPL",
            "ctransreceipt" => "75L056478J0855102",
            "ctranstime" => "1421479488",
            "ctransvendor" => "304399",
            "cupsellreceipt" => '',
            "cvendthru" => "c=TP-SEHWOgin3xe9xuPjmnzx",
            "cverify" => "C444171E"
        ];

        $this->sendJvzIpnPost($params);

        $u = cUser::find()->where(['email' => $email])->all();

        //check user_actions
        $ua = cUserAction::find()->where(['user_id' => $u[0]->id])->all();
        //there should only be 2 actions at this point
        $this->assertCount(2, $ua);
        //it should be 'Account Created'
        $this->assertEquals('Account Upgraded', $ua[1]->action);

        //check ipn log
        $jil = cJvzIpnLog::find()->where(['cproditem' => $params['cproditem']])->all();
        //there should only be one log item at this point
        $this->assertCount(1, $jil);
        //it should be 'SALE'
        $this->assertEquals('SALE', $jil[0]->ctransaction);
    }

    public function testActionJvzIpnChangeToYearlyPlan()
    {
        $email = 'jvzipn_test@teespy.com';
        //create account

        $params = [
            "caffitid" => "8482583",
            "ccustcc" => "US",
            "ccustemail" => "jvzipn_test@teespy.com",
            "ccustname" => "Nathan Sanden",
            "ccuststate" => "",
            "cproditem" => "150340",
            "cprodtitle" => "Postradamus - Facebook Page Scheduler and Viral Content Curator - Unlimited Package (Upgrade)",
            "cprodtype" => "RECURRING",
            "ctransaction" => "SALE",
            "ctransaffiliate" => "0",
            "ctransamount" => "1.00",
            "ctranspaymentmethod" => "PYPL",
            "ctransreceipt" => "75L056478J0855102",
            "ctranstime" => "1421479488",
            "ctransvendor" => "304399",
            "cupsellreceipt" => '',
            "cvendthru" => "c=TP-SEHWOgin3xe9xuPjmnzx",
            "cverify" => "C444171E"
        ];

        $this->sendJvzIpnPost($params);

        $u = cUser::find()->where(['email' => $email])->all();

        //check user_actions
        $ua = cUserAction::find()->where(['user_id' => $u[0]->id])->all();
        //there should only be 2 actions at this point
        $this->assertCount(3, $ua);
        //it should be 'Account Created'
        $this->assertEquals('Account Upgraded', $ua[1]->action);

        //check ipn log
        $jil = cJvzIpnLog::find()->where(['cproditem' => $params['cproditem']])->all();
        //there should only be one log item at this point
        $this->assertCount(1, $jil);
        //it should be 'SALE'
        $this->assertEquals('SALE', $jil[0]->ctransaction);
    }

    public function testActionJvzIpnCancel()
    {
        $email = 'jvzipn_test@teespy.com';
        //create account

        $params = [
            "caffitid" => "8482583",
            "ccustcc" => "US",
            "ccustemail" => "jvzipn_test@teespy.com",
            "ccustname" => "Nathan Sanden",
            "ccuststate" => "",
            "cproditem" => "108695",
            "cprodtitle" => "Postradamus - Facebook Page Scheduler and Viral Content Curator",
            "cprodtype" => "RECURRING",
            "ctransaction" => "CANCEL-REBILL",
            "ctransaffiliate" => "0",
            "ctransamount" => "1.00",
            "ctranspaymentmethod" => "PYPL",
            "ctransreceipt" => "75L056478J0855102",
            "ctranstime" => "1421479488",
            "ctransvendor" => "304399",
            "cupsellreceipt" => '',
            "cvendthru" => "c=TP-SEHWOgin3xe9xuPjmnzx",
            "cverify" => "C444171E"
        ];

        $this->sendJvzIpnPost($params);

        $u = cUser::find()->where(['email' => $email])->all();

        //check user_actions
        $ua = cUserAction::find()->where(['user_id' => $u[0]->id])->all();
        //there should only be 4 actions at this point
        $this->assertCount(4, $ua);
        //it should be 'Account Created'
        $this->assertEquals('Account Cancelled', $ua[3]->action);

        //check ipn log
        $jil = cJvzIpnLog::find()->where(['cproditem' => $params['cproditem']])->all();
        //there should only be 2 ipn logs at this point (KEY!!!!!!! for this product id!)
        $this->assertCount(2, $jil);
        //it should be 'SALE'
        $this->assertEquals('CANCEL-REBILL', $jil[1]->ctransaction);
    }

    public function sendIpnPost($params)
    {
        $curl = new \Buzz\Client\Curl;
        set_time_limit(120);
        $curl->setTimeout(120);
        $browser = new \Buzz\Browser($curl);

        // finding account's path
        $url = "http://localhost/postradamus/frontend/web/index-test.php?r=order/jvz-ipn";

        $response = $browser->post($url, [], $params);

        if (200 != $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), 'Couldn\'t get IPN');
        }

        return $response->getContent();
    }

    public function testLogAccountAction()
    {
        $this->assertTrue($this->order->logAccountAction(1, 'Account Downgraded'));
        $ua = cUserAction::find()->where(['user_id' => 1, 'action' => 'Account Downgraded'])->all();
        $this->assertCount(1, $ua);
    }

    public function testModifyAccount()
    {
        $u = cUser::find()->where(['id' => 99])->one();

        $this->assertEquals(1, $u->plan_id);
        $this->assertEquals(10, $u->status);
        //change the user plan from 10 to 25
        $this->order->modifyAccount($u, ['plan_id' => 4]);
        $this->assertEquals(4, $u->plan_id);
        $this->assertEquals(10, $u->status);
        $ua = cUserAction::find()->where(['user_id' => $u->id, 'action' => 'Account Upgraded'])->all();
        $this->assertCount(1, $ua);

        //change the user plan from 25 to 15
        $this->order->modifyAccount($u, ['plan_id' => 2]);
        $this->assertEquals(2, $u->plan_id);
        $this->assertEquals(10, $u->status);
        $ua = cUserAction::find()->where(['user_id' => $u->id, 'action' => 'Account Downgraded'])->all();
        $this->assertCount(1, $ua);

        //change the user status from 10 to 0
        $this->order->modifyAccount($u, ['status' => 0]);
        $this->assertEquals(2, $u->plan_id);
        $this->assertEquals(0, $u->status);
        $ua = cUserAction::find()->where(['user_id' => $u->id, 'action' => 'Account De-activated'])->all();
        $this->assertCount(1, $ua);

        //change the user status from 0 to 10
        $this->order->modifyAccount($u, ['status' => 10]);
        $this->assertEquals(2, $u->plan_id);
        $this->assertEquals(10, $u->status);
        $ua = cUserAction::find()->where(['user_id' => $u->id, 'action' => 'Account Re-activated'])->all();
        $this->assertCount(1, $ua);

        //make no changes (payment)
        $this->order->modifyAccount($u);
        $this->assertEquals(2, $u->plan_id);
        $this->assertEquals(10, $u->status);
        $ua = cUserAction::find()->where(['user_id' => $u->id, 'action' => 'Payment Received'])->all();
        $this->assertCount(1, $ua);
    }

    public function testCreateAccount()
    {
        cUser::deleteAll('email = "testuser@teespy.com"');
        $this->order->createAccount('testuser@teespy.com', 'Nate', 'Sanden', 4);
        $u = cUser::find()->where(['email' => 'testuser@teespy.com', 'first_name' => 'Nate', 'last_name' => 'Sanden', 'plan_id' => 4, 'status' => 10])->all();
        $this->assertCount(1, $u);

        cUser::deleteAll('email = "testuser2@teespy.com"');
        $this->order->createAccount('testuser2@teespy.com', 'Nate 2', 'Sanden 2', 1);
        $u = cUser::find()->where(['email' => 'testuser2@teespy.com', 'first_name' => 'Nate 2', 'last_name' => 'Sanden 2', 'plan_id' => 1, 'status' => 10])->all();
        $this->assertCount(1, $u);
    }

    public function testGetEndingDate()
    {
        $recurring_payment = '{"meta":{"status":{"http_status_code":200,"code":2000,"message":"Success","detail":null},"results_count":1,"api_version":"2.0"},"results":[{"id":468793,"status":"ACTIVE","current_payments":2,"max_number_of_payments":120,"max_total_of_all_payments":"5594.00","max_amount_per_payment":"47.00","next_payment":"47.00","paypal_email":"hkicenet@gmail.com","contact_email":"hkicenet@gmail.com","code":null,"price":"47.00","payment_period":1,"payment_count":119,"payment_first_payout":"0.5","has_payment_trial":true,"payment_trial_price":"1.00","payment_trial_period":3,"payment_trial_payout":"0","payout":null,"current_payments_amount":"48.00","created":"2015-01-20T12:18:01+00:00","preKey":"PA-0CL49263YS1480421","sender_email":"hkicenet@gmail.com","last_date":"2015-01-24T05:00:00+00:00","next_date":"2015-02-24T05:00:00+00:00","ip":"42.2.69.84","referrer":"https:\/\/www.jvzoo.com\/b\/0\/142768\/99","tid":null,"vtid":null,"product_id":142768}]}';

        $this->assertEquals('2015-02-24', $this->order->getEndingDate(json_decode($recurring_payment)));
    }

    public function testGetAffiliateCommissionPercent()
    {
        $recurring_payment = '{"meta":{"status":{"http_status_code":200,"code":2000,"message":"Success","detail":null},"results_count":1,"api_version":"2.0"},"results":[{"id":468793,"status":"ACTIVE","current_payments":2,"max_number_of_payments":120,"max_total_of_all_payments":"5594.00","max_amount_per_payment":"47.00","next_payment":"47.00","paypal_email":"hkicenet@gmail.com","contact_email":"hkicenet@gmail.com","code":null,"price":"47.00","payment_period":1,"payment_count":119,"payment_first_payout":"0.5","has_payment_trial":true,"payment_trial_price":"1.00","payment_trial_period":3,"payment_trial_payout":"0.50","payout":null,"current_payments_amount":"48.00","created":"2015-01-20T12:18:01+00:00","preKey":"PA-0CL49263YS1480421","sender_email":"hkicenet@gmail.com","last_date":"2015-01-24T05:00:00+00:00","next_date":"2015-02-24T05:00:00+00:00","ip":"42.2.69.84","referrer":"https:\/\/www.jvzoo.com\/b\/0\/142768\/99","tid":null,"vtid":null,"product_id":142768}]}';

        $this->assertEquals('50', $this->order->getAffiliateCommissionPercent(json_decode($recurring_payment)));
    }

    public function testIsAffiliateOwned()
    {
        $recurring_payment = '{"meta":{"status":{"http_status_code":200,"code":2000,"message":"Success","detail":null},"results_count":1,"api_version":"2.0"},"results":[{"id":468793,"status":"ACTIVE","current_payments":2,"max_number_of_payments":120,"max_total_of_all_payments":"5594.00","max_amount_per_payment":"47.00","next_payment":"47.00","paypal_email":"hkicenet@gmail.com","contact_email":"hkicenet@gmail.com","code":null,"price":"47.00","payment_period":1,"payment_count":119,"payment_first_payout":"0.5","has_payment_trial":true,"payment_trial_price":"1.00","payment_trial_period":3,"payment_trial_payout":"0.50","payout":null,"current_payments_amount":"48.00","created":"2015-01-20T12:18:01+00:00","preKey":"PA-0CL49263YS1480421","sender_email":"hkicenet@gmail.com","last_date":"2015-01-24T05:00:00+00:00","next_date":"2015-02-24T05:00:00+00:00","ip":"42.2.69.84","referrer":"https:\/\/www.jvzoo.com\/b\/0\/142768\/99","tid":null,"vtid":null,"product_id":142768}]}';

        $this->assertEquals(true, $this->order->isAffiliateOwned(json_decode($recurring_payment)));
    }

}