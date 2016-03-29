<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_connection_pinterest".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $campaign_id
 * @property string $username
 * @property string $password
 */
class cConnectionPinterest extends \yii\db\ActiveRecord
{
    public $campaigns = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_connection_pinterest';
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

    public function validCredentials($attribute)
    {
        if($this->username != '' && $this->password != '')
        {
            $p = new \backend\components\PinterestHelper($this->username, $this->password);
            $connection = $p->connect();

            if ($connection != '') {
                $this->addError($attribute, $connection);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'campaign_id'], 'required'],
            [['user_id', 'campaign_id'], 'integer'],
            [['username', 'password'], 'validCredentials'],
            [['username', 'password'], 'safe'],
            [['username', 'password'], 'string', 'max' => 255]
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
            'username' => 'Email',
            'password' => 'Password',
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
