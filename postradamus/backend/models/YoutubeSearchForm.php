<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class YoutubeSearchForm extends Model
{
    const SAFE_SEARCH_MODERATE = 'moderate';
    const SAFE_SEARCH_NONE = 'none';
    const SAFE_SEARCH_STRICT = 'strict';

    public $keywords;
    public $hide_used_content = true;
    public $safe_search = self::SAFE_SEARCH_MODERATE;
    public $category;
    public $order = 'viewCount';
    public $definition = 'any';
    public $duration = 'any';
    public $type = 'any';

    public function rules()
    {
        return [
            // username and password are both required
            [['keywords', 'hide_used_content', 'safe_search', 'order', 'category', 'definition', 'duration', 'type'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'keywords' => 'Keywords',
            'hide_used_content' => 'Don\'t show content i\'ve already saved.',
            'order' => 'Result Type',
            'type' => 'Film Type'
        ];
    }

}
