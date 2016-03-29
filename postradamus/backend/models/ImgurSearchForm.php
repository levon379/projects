<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class ImgurSearchForm extends Model
{
    public $keywords;
    public $hide_used_content = true;

    public function rules()
    {
        return [
            // username and password are both required
            [['keywords'], 'required'],
            [['hide_used_content'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'keywords' => 'Keywords',
            'hide_used_content' => 'Don\'t show content i\'ve already saved.'
        ];
    }

}
