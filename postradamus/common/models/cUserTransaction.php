<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_transaction".
 *
 * @property string $user_id
 * @property string $product_id
 * @property string $type
 * @property string $ipn
 * @property integer $created_at
 */
class cUserTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_user_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'created_at'], 'integer'],
            [['type', 'created_at'], 'required'],
            [['ipn'], 'safe'],
            [['type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'type' => 'Type',
            'created_at' => 'Created At',
        ];
    }
}
