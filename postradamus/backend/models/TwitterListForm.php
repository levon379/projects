<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class TwitterListForm extends Model
{
    public $list_id;
    public $hide_used_content = true;
    public $result_type = 'mixed';
    public $include_retweets = 0;

    public function rules()
    {
        return [
            // username and password are both required
            [['list_id'], 'required'],
            [['hide_used_content', 'include_retweets'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'list_id' => 'List',
            'hide_used_content' => 'Don\'t show content i\'ve already saved.'
        ];
    }

}
