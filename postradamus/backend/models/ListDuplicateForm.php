<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class ListDuplicateForm extends Model
{
    public $from_list_id;
    public $to_list_name;

    public function init()
    {
        return parent::init();
    }

    public function rules()
    {
        return [
            // username and password are both required
            [['from_list_id', 'to_list_name'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'from_list_id' => 'Copy From List',
            'to_list_name' => 'To List Name'
        ];
    }

}
