<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "todolists".
 *
 * @property integer $id
 * @property integer $swot_id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class Todolists extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'todolists';
    }

    /**
     * behaviors
     */

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['swot_id', 'name'], 'required'],
            [['swot_id'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'swot_id' => 'Swot ID',
            'name' => 'Name',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getTodos()
    {
        return $this->hasMany(Todos::className(),['todolist_id' => 'id']);
    }
    
    public function getSwot()
    {
        return $this->hasOne(Swots::className(),['swot_id' => 'id']);
    }

}
