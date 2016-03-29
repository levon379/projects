<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_transaction_newest".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $amount
 * @property string $fee
 * @property string $net
 * @property string $details
 * @property integer $created
 */
class cTransactionNewest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_transaction_newest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'amount', 'fee', 'net', 'details', 'created'], 'required'],
            [['user_id', 'created'], 'integer'],
            [['details'], 'string'],
            [['type', 'amount', 'fee', 'net'], 'string', 'max' => 55]
        ];
    }

    public function getUser()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasOne(cUser::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'amount' => 'Amount',
            'fee' => 'Fee',
            'net' => 'Net',
            'details' => 'Details',
            'created' => 'Created',
        ];
    }
}
