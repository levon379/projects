<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class TwitterTimelineForm extends Model
{
    public $hide_used_content = true;

    public function rules()
    {
        return [
            // username and password are both required
            [['hide_used_content'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'hide_used_content' => 'Don\'t show content i\'ve already saved.'
        ];
    }

}
