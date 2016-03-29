<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\cListPost;

/**
 * Import form
 */
class CsvImportForm extends Model
{
    public $list_id;
    
    public function attributeLabels()
    {
        return [
            'list_id' => 'To',
        ];
    }
}
