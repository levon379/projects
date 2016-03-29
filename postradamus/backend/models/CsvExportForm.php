<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\cListPost;

/**
 * Export form
 */
class CsvExportForm extends Model
{
    public $list_id;
    public $export_type;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['publish'] = ['list_id'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            // username and password are both required
            [['list_id'], 'required'],
            [['list_id'], 'hasScheduledPosts', 'on' => ['publish']],
            // rememberMe must be a boolean value
            [['list_id', 'export_type'], 'integer'],
        ];
    }

    public function hasScheduledPosts($attribute)
    {
        $posts = cListPost::find()->where('scheduled_time IS NOT NULL')->andWhere(['list_id' => $this->$attribute])->count();
        if ($posts == 0) {
            $this->addError($attribute, 'The list you chose contains no scheduled posts.');
        }
    }

    public function attributeLabels()
    {
        return [
            'list_id' => 'From',
        ];
    }

}
