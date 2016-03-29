<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class InstagramSearchForm extends Model
{
    public $hide_used_content = true;
    public $keywords;
    public $from_source;
    public $type = 0;

    public function rules()
    {
        return [
            // username and password are both required
            //[['page_id'], 'required'],
            [['hide_used_content', 'keywords', 'from_source', 'type'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'keywords' => 'Tag',
            'from_source' => 'Source',
            'hide_used_content' => 'Don\'t show content i\'ve already saved.',
            'type' => 'Type'
        ];
    }

}
