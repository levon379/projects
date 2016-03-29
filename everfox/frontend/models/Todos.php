<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "todos".
 *
 * @property integer $id
 * @property integer $priority
 * @property integer $todolist_id
 * @property integer $user_id
 * @property string $todo
 * @property string $details
 * @property string $due_on
 * @property integer $complete
 * @property string $created_at
 * @property string $updated_at
 */
class Todos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'todos';
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
            [['priority', 'user_id', 'todo', 'complete'], 'required'],
            [['priority', 'todolist_id', 'user_id', 'complete'], 'integer'],
            [['details'], 'string'],
            [['due_on', 'created_at', 'updated_at'], 'safe'],
            [['todo'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'priority' => 'Priority',
            'todolist_id' => 'Todolist ID',
            'user_id' => 'User ID',
            'todo' => 'Todo',
            'details' => 'Details',
            'due_on' => 'Due On',
            'complete' => 'Complete',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function getTodolist()
    {
        return $this->hasOne(Todolists::className(),['todolist_id' => 'id']);
    }
    
}
