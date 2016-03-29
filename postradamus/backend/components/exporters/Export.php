<?php

namespace backend\components\exporters;

use yii\base\Object;

class Export extends Object {
    public $prop1;
    public $prop2;

    public function __construct($config = [])
    {
        // ... initialization before configuration is applied

        parent::__construct($config);
    }

    public function init()
    {
        parent::init();

        // ... initialization after configuration is applied
    }

    public function postSent($params)
    {
        //create a post
        $listSentPost = new \common\models\cListSentPost;
        $listSentPost->setAttributes($params);
        $listSentPost->save(false);
    }

}