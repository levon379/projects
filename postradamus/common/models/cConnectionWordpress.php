<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_connection_wordpress".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $campaign_id
 * @property string $xml_rpc_url
 * @property string $username
 * @property string $password
 */
class cConnectionWordpress extends \yii\db\ActiveRecord
{
    public $campaigns;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_connection_wordpress';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'campaign_id'], 'required'],
            [['user_id', 'campaign_id'], 'integer'],
            [['xml_rpc_url', 'username', 'password'], 'safe']
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
            'campaign_id' => 'Campaign ID',
            'xml_rpc_url' => 'Blog URL',
            'username' => 'Username',
            'password' => 'Password',
        ];
    }

    public static function findConnection()
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

        $query->andWhere(['or', 'campaign_id=' . (int)Yii::$app->session->get('campaign_id')]);
        return $query;
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
            if($this->xml_rpc_url != '' && substr($this->xml_rpc_url, -1) != '/')
            {
                $this->xml_rpc_url .= '/';
            }
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
