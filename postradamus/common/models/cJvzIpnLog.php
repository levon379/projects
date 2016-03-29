<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jvz_ipn_log".
 *
 * @property integer $id
 * @property string $ccustemail
 * @property string $cproditem
 * @property string $ctransaction
 * @property integer $valid
 * @property string $post
 * @property integer $created_at
 */
class cJvzIpnLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_jvz_ipn_log';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ccustemail', 'valid', 'cproditem', 'ctransaction', 'post', 'created_at'], 'required'],
            [['post'], 'string'],
            [['created_at'], 'integer'],
            [['ccustemail', 'cproditem', 'ctransaction'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ccustemail' => 'Ccustemail',
            'cproditem' => 'Cproditem',
            'ctransaction' => 'Ctransaction',
            'post' => 'Post',
            'created_at' => 'Created At',
        ];
    }
}
