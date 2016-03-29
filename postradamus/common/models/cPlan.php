<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plan".
 *
 * @property integer $id
 * @property integer $plan_id
 * @property string $name
 * @property string $jvzoo_product_id
 * @property string $jvzoo_product_upgrade_id
 */
class cPlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'jvzoo_product_id', 'jvzoo_product_upgrade_id', 'plan_id'], 'required'],
            [['plan_id'], 'integer'],
            [['name', 'jvzoo_product_id', 'jvzoo_product_upgrade_id'], 'string', 'max' => 255]
        ];
    }

    public function getUpgradeId()
    {
        if($this->plan_id == 1)
        {
            return 2;
        }
        if($this->plan_id == 2)
        {
            return 3;
        }
        return false;
    }

    public function getUpgradeName()
    {
        if($this->getUpgradeId())
        {
            $upgrade_model = self::find()->where(['plan_id' => $this->getUpgradeId()])->one();
            return $upgrade_model->name;
        }
        return false;
    }

    public function getUpgradeUrl()
    {
        if($this->getUpgradeId())
        {
            $upgrade_model = self::find()->where(['plan_id' => $this->getUpgradeId()])->one();
            if(strstr($upgrade_model->jvzoo_product_upgrade_id, '|'))
            {
                $uid = explode("|", $upgrade_model->jvzoo_product_upgrade_id);
                $id = $uid[0];
            }
            else
            {
                $id = $upgrade_model->jvzoo_product_upgrade_id;
            }
            return 'https://www.jvzoo.com/b/0/' . $id. '/99';
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plan_id' => 'Plan',
            'name' => 'Name',
            'jvzoo_product_id' => 'Jvzoo Product ID',
            'jvzoo_product_upgrade_id' => 'Jvzoo Product Upgrade ID',
        ];
    }
}
