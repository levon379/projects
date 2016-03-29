<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class FacebookSearchForm extends Model
{
    public $page_id;
    public $group_id;
    public $posted_by = 0;
    public $post_type = 0;
    public $hide_used_content = true;
    public $from_page1;
    public $from_page2;
    public $from_page3;
    public $from_group1;
    public $from_group2;
    public $from_group3;
    public $from_post_id;
    public $large_results = 0;
    public $cache = 1;

    public function rules()
    {
        return [
            // username and password are both required
            //[['page_id'], 'required'],
            [['hide_used_content', 'posted_by', 'post_type', 'cache', 'large_results', 'from_page1', 'from_page2', 'from_page3', 'from_group1', 'from_group2', 'from_group3', 'page_id', 'group_id', 'from_post_id'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'page_id' => 'Page',
            'posted_by' => 'Posted By',
            'post_type' => 'Post Type',
            'hide_used_content' => 'Don\'t show content i\'ve already saved.',
            'from_page1' => 'Page',
            'from_page2' => 'Page',
            'from_page3' => 'Page',
            'from_group1' => 'Group',
            'from_group2' => 'Group',
            'from_group3' => 'Group',
            'large_results' => 'Large number of results',
            'from_post_id' => 'Post ID or Post URL',
        ];
    }

}
