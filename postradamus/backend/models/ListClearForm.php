<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class ListClearForm extends Model
{
    public $list_id;

    public function init()
    {
        return parent::init();
    }

    public function rules()
    {
        return [
            // username and password are both required
            [['list_id'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'list_id' => 'List',
        ];
    }

}
