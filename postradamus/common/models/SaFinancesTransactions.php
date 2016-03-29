<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sa_finances_transactions".
 *
 * @property integer $TransID
 * @property string $Category
 * @property string $Site
 * @property string $Label
 * @property string $Description
 * @property string $Amount
 * @property string $Date
 * @property integer $parent_id
 * @property integer $auto
 */
class SaFinancesTransactions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'savingadviceOLD.sa_finances_transactions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Description', 'parent_id', 'auto'], 'required'],
            [['Description'], 'string'],
            [['Amount'], 'number'],
            [['Date'], 'safe'],
            [['parent_id', 'auto'], 'integer'],
            [['Category', 'Label'], 'string', 'max' => 50],
            [['Site'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TransID' => 'Trans ID',
            'Category' => 'Category',
            'Site' => 'Site',
            'Label' => 'Label',
            'Description' => 'Description',
            'Amount' => 'Amount',
            'Date' => 'Date',
            'parent_id' => 'Parent ID',
            'auto' => 'Auto',
        ];
    }
}
