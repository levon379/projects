<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_action".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $action
 * @property string $post
 * @property string $get
 * @property integer $created_at
 */
class cUserAction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_user_action';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(cUser::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'action', 'post', 'get', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['action'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'action' => 'Action',
            'get' => 'Get',
            'post' => 'Post',
            'created_at' => 'Created At',
        ];
    }
}
