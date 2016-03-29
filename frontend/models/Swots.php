<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "swots".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $priority
 * @property string $name
 * @property string $description
 * @property string $type
 * @property string $taggedwith
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class Swots extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'swots';
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
            [['category_id', 'priority', 'user_id'], 'integer'],
            [['name', 'type', 'user_id'], 'required'],
            [['description', 'type'], 'string'],
            [['taggedwith', 'type'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'priority' => 'Priority',
            'name' => 'Name',
            'description' => 'Description',
            'taggedwith' => '',
            'type' => 'Type',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getTodolists()
    {
        return $this->hasMany(Todolists::className(),['swot_id' => 'id']);
    }
    
    public function getCategory()
    {
        return $this->hasMany(Categories::className(),['category_id' => 'id']);
    }
    
}
