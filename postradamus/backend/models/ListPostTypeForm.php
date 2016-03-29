<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class ListPostTypeForm extends Model
{
    public $list_id;
    public $post_type_id;
    public $posts = [];

    public function init()
    {
        return parent::init();
    }

    public function rules()
    {
        return [
            // username and password are both required
            [['list_id', 'posts'], 'required'],
            ['post_type_id', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'list_id' => 'List',
            'post_type_id' => 'Post Type',
        ];
    }

}
