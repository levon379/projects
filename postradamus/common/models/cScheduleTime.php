<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_schedule_time".
 *
 * @property integer $id
 * @property integer $schedule_id
 * @property integer $user_id
 * @property integer $campaign_id
 * @property integer $weekday
 * @property string $time
 */
class cScheduleTime extends \yii\db\ActiveRecord
{
    public $post_types;
    public $weekdays;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_schedule_time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schedule_id', 'user_id', 'weekday', 'time'], 'required'],
            [['schedule_id', 'user_id', 'weekday'], 'integer'],
            [['time', 'post_types', 'weekdays'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'schedule_id' => 'Schedule ID',
            'user_id' => 'User ID',
            'campaign_id' => 'Campaign ID',
            'weekday' => 'Weekday',
            'time' => 'Time',
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

    public function getPostTypes()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasMany(cScheduleTimePostType::className(), ['schedule_time_id' => 'id']);
    }

}
