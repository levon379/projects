<?php
namespace backend\components\importers;

use common\models\cListPost;
use Yii;
use yii\web\HttpException;
use \Abraham\TwitterOAuth;

class Twitter extends Import
{
    protected $origin_type = cListPost::ORIGIN_TWITTER;

    const OAUTH_ACCESS_TOKEN = '557335920-rakyUK5acMTB27pdySLpcKfL3A9fqOevFGdFE5qs';
    const OAUTH_ACCESS_TOKEN_SECRET = 'sVQYzRrDg3wuH3zzOYYpKEqmNOw33QURpKGG9ipmBbCPO';
    const CONSUMER_KEY = 'vvNAA8Rd0yF4kJqoATFEOyYLo';
    const CONSUMER_SECRET = '2gjX1PMx4K21ZOdritIJd4M8DvKVmfBpTN64CSQ7Qn70w7pavA';

    public $twitter;
    public $settings;

    public function __construct($config = [])
    {
        $this->settings = array(
            'oauth_access_token' => ((isset($config['oauth_access_token']) && trim($config['oauth_access_token']) != '') ? $config['oauth_access_token'] : self::OAUTH_ACCESS_TOKEN),
            'oauth_access_token_secret' => ((isset($config['oauth_access_token_secret']) && trim($config['oauth_access_token_secret']) != '') ? $config['oauth_access_token_secret'] : self::OAUTH_ACCESS_TOKEN_SECRET),
            'consumer_key' => ((isset($config['consumer_key']) && trim($config['consumer_key']) != '') ? $config['consumer_key'] : self::CONSUMER_KEY),
            'consumer_secret' => ((isset($config['consumer_secret']) && trim($config['consumer_secret']) != '') ? $config['consumer_secret'] : self::CONSUMER_SECRET)
        );
    }

}