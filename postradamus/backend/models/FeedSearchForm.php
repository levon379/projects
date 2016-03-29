<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * RSS Search form
 */
class FeedSearchForm extends Model
{
    public $feed1, $feed2, $feed3;
    public $feed_search_pill = '#pill_feed2';
    public $hide_used_content = true;

    public function rules()
    {
        return [
            // username and password are both required
            [['feed1', 'feed2', 'feed3', 'feed_search_pill'], 'safe'],
            [['hide_used_content'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'feed1' => 'Feed URL',
            'feed2' => 'Feed Search',
            'feed3' => 'Saved Feed',
            'hide_used_content' => 'Don\'t show content i\'ve already saved.'
        ];
    }

}
