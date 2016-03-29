<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tbl_sale".
 *
 * @property integer $id
 * @property string $receipt_no
 * @property string $ipn_fields
 * @property integer $updated_at
 * @property integer $created_at
 */
class cSale extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_sale';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receipt_no', 'ipn_fields', 'updated_at', 'created_at'], 'required'],
            [['ipn_fields'], 'string'],
            [['updated_at', 'created_at'], 'integer'],
            [['receipt_no'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'receipt_no' => 'Receipt No',
            'ipn_fields' => 'Ipn Fields',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
