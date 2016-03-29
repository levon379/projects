<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "tbl_list_sent_meta".
 *
 * @property integer $id
 * @property integer $list_sent_id
 * @property integer $list_id
 * @property integer $user_id
 * @property string $key
 * @property string $value
 * @property integer $updated_at
 * @property integer $created_at
 */
class cListSentMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_list_sent_meta';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('UNIX_TIMESTAMP()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['list_sent_id', 'list_id', 'user_id', 'key', 'value', 'updated_at', 'created_at'], 'required'],
            [['list_sent_id', 'list_id', 'user_id', 'updated_at', 'created_at'], 'integer'],
            [['key', 'value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'list_sent_id' => 'List Sent ID',
            'list_id' => 'List ID',
            'user_id' => 'User ID',
            'key' => 'Key',
            'value' => 'Value',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
