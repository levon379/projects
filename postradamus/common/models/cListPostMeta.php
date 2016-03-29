<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_list_post_meta".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $list_id
 * @property integer $list_post_id
 * @property string $key
 * @property string $value
 */
class cListPostMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_list_post_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'list_id', 'list_post_id', 'key', 'value'], 'required'],
            [['user_id', 'list_id', 'list_post_id'], 'integer'],
            [['key', 'value'], 'string', 'max' => 255]
        ];
    }

    public static function find()
    {
        $query = parent::find();
        $query->where(['and', ['or', 'tbl_list.user_id=' . Yii::$app->user->id, 'tbl_list.user_id=' . Yii::$app->user->identity->getField('parent_id')]]);
        return $query;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'list_id' => 'List ID',
            'list_post_id' => 'List Post ID',
            'key' => 'Key',
            'value' => 'Value',
        ];
    }
}
