<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_amazon_connection".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $campaign_id
 * @property string $country
 * @property string $aws_api_access_key
 * @property string $aws_api_secret_key
 * @property string $aws_associate_tag
 */
class cConnectionAmazon extends \yii\db\ActiveRecord
{
    public $campaigns = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_connection_amazon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aws_associate_tag'], 'required'],
            [['user_id', 'aws_api_access_key', 'aws_api_secret_key', 'country', 'campaign_id', 'aws_associate_tag'], 'safe'],
            [['user_id', 'campaigns'], 'integer'],
            [['aws_api_access_key', 'aws_api_secret_key', 'aws_associate_tag'], 'string', 'max' => 255]
        ];
    }

    public static function find()
    {
        $query = parent::find();

        if(Yii::$app->user->identity->getField('parent_id') != 0)
        {
            $query->andWhere(['or', 'user_id=' . Yii::$app->user->id, 'user_id=' . Yii::$app->user->identity->getField('parent_id')]);
        }
        else
        {
            $sub_accounts = \common\models\cUser::find()->where(['parent_id' => Yii::$app->user->id])->all();
            $user_ids = [];
            foreach($sub_accounts as $user)
            {
                $user_ids[] = $user->id;
            }
            $query->andWhere(['or', 'user_id=' . Yii::$app->user->id, ['in', 'user_id', $user_ids]]);
        }

        $query->andWhere(['or', 'campaign_id=' . (int)Yii::$app->session->get('campaign_id'), 'campaign_id=0']);
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
            'campaign_id' => 'Campaign',
            'aws_api_access_key' => 'AWS API Access Key',
            'aws_api_secret_key' => 'AWS API Secret Key',
            'aws_associate_tag' => 'AWS Associate Tag',
        ];
    }

    public function afterFind()
    {
        if($this->campaign_id == 0)
        {
            $this->campaigns = 1;
        }
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->campaigns == 1)
            {
                $this->campaign_id = 0;
            }
            else
            {
                $this->campaign_id = (int)Yii::$app->session->get('campaign_id');
            }
            return true;
        } else {
            return false;
        }
    }
}
