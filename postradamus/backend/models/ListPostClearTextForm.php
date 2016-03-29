<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class ListPostClearTextForm extends Model
{
    public $list_id;
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
        ];
    }

    public function attributeLabels()
    {
        return [
            'list_id' => 'List',
        ];
    }

}
