<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_schedule_time_post_type".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $campaign_id
 * @property integer $post_type_id
 * @property integer $schedule_id
 * @property integer $schedule_time_id
 */
class cScheduleTimePostType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_schedule_time_post_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'campaign_id', 'post_type_id', 'schedule_id', 'schedule_time_id'], 'required'],
            [['user_id', 'campaign_id', 'post_type_id', 'schedule_id', 'schedule_time_id'], 'integer']
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
            'post_type_id' => 'Post Type ID',
            'schedule_id' => 'Schedule ID',
            'schedule_time_id' => 'Schedule Item ID',
        ];
    }
}
