<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tbl_transaction".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email_address
 * @property string $amount
 * @property string $ipn_data
 * @property string $payment_status
 */
class cTransactionNew extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_transaction_new';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'identifier', 'first_name', 'last_name', 'email_address', 'amount', 'txn_type', 'fee', 'created', 'ipn_data', 'payment_status'], 'required'],
            [['id', 'created'], 'integer'],
            [['ipn_data'], 'string'],
            [['first_name', 'last_name', 'email_address', 'amount', 'payment_status'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email_address' => 'Email Address',
            'amount' => 'Amount',
            'ipn_data' => 'Ipn Data',
            'payment_status' => 'Payment Status',
        ];
    }
}
