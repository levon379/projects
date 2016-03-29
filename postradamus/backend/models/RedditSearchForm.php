<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class RedditSearchForm extends Model
{
    public $keywords;
    public $hide_used_content = true;
    public $large_images = false;
    public $subreddit;
    public $type;

    public function rules()
    {
        return [
            // username and password are both required
            [['hide_used_content', 'keywords', 'type', 'subreddit', 'large_images'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'keywords' => 'Keywords',
            'subreddit' => 'Sub Reddit',
            'large_images' => 'Large Images (Attempts to find larger images, could be very slow!)',
            'hide_used_content' => 'Don\'t show content i\'ve already saved.'
        ];
    }

}
