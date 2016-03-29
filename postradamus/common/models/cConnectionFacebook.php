<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_connection_facebook".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $facebook_app_id
 * @property string $facebook_secret
 */
class cConnectionFacebook extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_connection_facebook';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'facebook_app_id', 'facebook_secret'], 'safe'],
            [['user_id'], 'integer'],
            [['facebook_app_id', 'facebook_secret'], 'string', 'max' => 255]
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
            'facebook_app_id' => 'Facebook App ID',
            'facebook_secret' => 'Facebook Secret',
        ];
    }
}
