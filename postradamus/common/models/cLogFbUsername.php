<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_log_fb_username".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $fb_user_name
 * @property string $fb_user_id
 */
class cLogFbUsername extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_log_fb_username';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'fb_user_name', 'fb_user_id'], 'required'],
            [['user_id'], 'integer'],
            [['fb_user_name', 'fb_user_id'], 'string', 'max' => 255]
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
            'fb_user_name' => 'Fb User Name',
            'fb_user_id' => 'Fb User ID',
        ];
    }
}
