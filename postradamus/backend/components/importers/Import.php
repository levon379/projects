<?php

namespace backend\components\importers;

use yii\base\Object;
use common\models\cListPost;
use common\models\cListPostDeleted;

class Import extends Object {

    private $_used_content;
    protected $origin_type;

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

    //this will get slow as user has 10000's of posts. at that point, we need to change it to run 1 query per search result
    protected function is_used( $origin_id, $user_id )
    {
        //cache it so we only run this query once
        if(!$this->_used_content)
        {
            $content1 = cListPostDeleted::find()->select(['origin_id'])->where(['user_id' => $user_id])->all();
            $content2 = cListPost::find()->select(['origin_id'])->where(['user_id' => $user_id])->all();
            $this->_used_content = array_merge($content1, $content2);
        }

        foreach($this->_used_content as $used_content)
        {
            if(/*$used_content->origin_type == $this->origin_type && */$used_content->origin_id == $origin_id)
            {
                return true;
            }
        }

        return false;
    }

}