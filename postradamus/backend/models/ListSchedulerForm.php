<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\cScheduleTime;

/**
 * Export form
 */
class ListSchedulerForm extends Model
{
    public $list_id;
    public $schedule_id;
    public $start_date;
    public $randomize_posts = false;
    public $randomize_time = false;
    public $unscheduled_posts_only = true;

    public function init()
    {
        if(!$this->start_date)
        {
            $this->start_date = date("Y-m-d", time() + 86400);
        }
        return parent::init();
    }

    public function rules()
    {
        return [
            // username and password are both required
            [['list_id', 'schedule_id', 'start_date'], 'required'],
            [['schedule_id'], 'hasTimes'],
            [['randomize_time', 'randomize_posts', 'unscheduled_posts_only'], 'safe']
        ];
    }

    public function hasTimes()
    {
        $times = cScheduleTime::find()->andWhere(['schedule_id' => $this->schedule_id])->count();
        if ($times == 0) {
            $message = 'The schedule you chose cannot be used because you haven\'t setup any times yet. <a href="' . Yii::$app->urlManager->createUrl(['schedule/update', 'id' => $this->schedule_id]) . '">Please do so</a> before using this schedule.';
            Yii::$app->session->setFlash('danger', $message);
            $this->addError('schedule_id', strip_tags($message));
        }
    }

    public function attributeLabels()
    {
        return [
            'list_id' => 'List',
            'schedule_id' => 'Schedule',
            'start_date' => 'Start Date',
            'randomize_posts' => 'Post Randomization',
            'randomize_time' => 'Time Randomization',
            'unscheduled_posts_only' => 'Unscheduled Posts Only'
        ];
    }

}
