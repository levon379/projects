<?php

namespace common\components;

use yii\base\Exception;
use yii\base\InvalidParamException;

class JvzooRest {

    const API_URL = 'https://api.jvzoo.com/v2.0';
    const API_KEY = '4b72c4abd3484403261ea841db9a098d:hsdjsvhsd';

    protected function beginCurl($end_point)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::API_URL . $end_point);
        curl_setopt($ch, CURLOPT_USERPWD, self::API_KEY);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        return $ch;
    }

    protected function endCurl($ch)
    {
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function getAffiliateStatus($product_id, $affiliate_id)
    {
        $ch = $this->beginCurl('/products/' . $product_id . '/affiliates/' . $affiliate_id);
        $response = $this->endCurl($ch);
        return $response;
    }

    public function getTransactionSummary($pay_key)
    {
        $ch = $this->beginCurl('/transactions/summaries/' . $pay_key);
        $response = $this->endCurl($ch);
        return $response;
    }

    public function getRecurringPayment($pre_key)
    {
        if(trim($pre_key) == '')
        {
            throw new Exception('$pre_key must not be empty.');
        }
        $ch = $this->beginCurl('/recurring_payment/' . $pre_key);
        $response = $this->endCurl($ch);
        return $response;
    }

    public function cancelRecurringPayment($pre_key)
    {
        if(trim($pre_key) == '')
        {
            throw new Exception('$pre_key must not be empty.');
        }
        $ch = $this->beginCurl('/recurring_payment/' . $pre_key);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $post_fields = http_build_query(['status' => 'CANCEL']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        $response = $this->endCurl($ch);
        return $response;
    }

}