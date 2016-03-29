<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class WebpageSearchForm extends Model
{
    public $webpage_url;
    public $hide_used_content = true;

    public function rules()
    {
        return [
            // username and password are both required
            [['webpage_url'], 'required'],
            [['hide_used_content'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'webpage_url' => 'Webpage URL',
            'hide_used_content' => 'Don\'t show content i\'ve already saved.'
        ];
    }

}
