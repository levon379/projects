<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class PinterestSearchForm extends Model
{
    public $keywords;
    public $results = 100;
    public $hide_used_content = true;

    public function rules()
    {
        return [
            // username and password are both required
            [['keywords', 'results'], 'required'],
            [['results'], 'in', 'range' => [100, 250, 500, 1000]],
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
