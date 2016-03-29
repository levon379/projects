<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_schedule".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 */
class cSchedule extends \yii\db\ActiveRecord
{

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
    public static function tableName()
    {
        return 'tbl_schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id', 'campaign_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
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
            'campaign_id' => 'Campaign',
            'name' => 'Name',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord)
                $this->campaign_id = (int)Yii::$app->session->get('campaign_id');
			return true;
        } else {
            return false;
        }
    }
}
