<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_campaign".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $image_url
 */
class cCampaign extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_campaign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            ['user_id', 'hasNoMoreThan', 'params' => ['max' => Yii::$app->postradamus->getPlanDetails(Yii::$app->user->identity->getField('plan_id'))['campaigns']]],
            [['user_id'], 'integer'],
            [['image'], 'safe'],
            [['name', 'image_url'], 'string', 'max' => 255]
        ];
    }

    public function hasNoMoreThan($attribute, $params)
    {
        $value = $this->$attribute;
        $count_lists = cList::find()->count();
        if ($count_lists >= $params['max']) {
            $this->addError($attribute, 'You cannot create more than ' . $params['max'] . ' campaigns. Please upgrade to add more.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'image_url' => 'Image Url',
        ];
    }

    public static function find()
    {
        $query = parent::find();


        if(Yii::$app->user->id)
        {

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

        }
        return $query;
    }
}
