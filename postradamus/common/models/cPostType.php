<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_post_type".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $campaign_id
 * @property string $name
 * @property string $description
 * @property string $color
 */
class cPostType extends \yii\db\ActiveRecord
{
    public $campaigns;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_post_type';
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
    public function rules()
    {
        return [
            [['user_id', 'name', 'color'], 'required'],
            [['user_id', 'campaign_id', 'campaigns'], 'integer'],
            [['description'], 'safe'],
            [['name', 'color'], 'string', 'max' => 255]
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
            'name' => 'Name',
            'description' => 'Description',
            'color' => 'Color',
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
