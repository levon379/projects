<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_list_post_deleted".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $origin_type
 * @property string $origin_id
 */
class cListPostDeleted extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_list_post_deleted';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'origin_type', 'origin_id'], 'required'],
            [['user_id', 'origin_type'], 'integer'],
            [['origin_id'], 'string', 'max' => 255]
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
            'origin_type' => 'Origin Type',
            'origin_id' => 'Origin ID',
        ];
    }
}
