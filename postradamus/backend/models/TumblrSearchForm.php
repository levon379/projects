<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class TumblrSearchForm extends Model
{
    public $keywords;
    public $before;
    public $hide_used_content = true;

    public function rules()
    {
        return [
            // username and password are both required
            [['keywords'], 'required'],
            [['before', 'hide_used_content'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'keywords' => 'Keywords',
            'before' => 'Before',
            'hide_used_content' => 'Don\'t show content i\'ve already saved.'
        ];
    }

}
