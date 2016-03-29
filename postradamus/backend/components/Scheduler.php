<?php

namespace backend\components;

use common\models\cListPost;
use common\models\cScheduleTime;
use yii\db\Expression;

class Scheduler {

    public $schedule_id;
    public $list_id;
    public $config = [];

    private $_postTimes;
    private $_postsToBeScheduled;
    private $_startTimeKey;
    private $_currentTimeKey;
    private $_previousWeekDay;
    private $_dayCount = 0;

    public function __construct($schedule_id, $list_id, $config = [])
    {
        $this->schedule_id = $schedule_id;
        $this->list_id = $list_id;
        $this->config = $config;
        $this->config['startDate'] = strtotime($config['startDate']);
    }

    public function getScheduleTimes()
    {
        if(!$this->_postTimes)
        {
            $this->_postTimes = cScheduleTime::find()->andWhere(['schedule_id' => $this->schedule_id])->orderBy('weekday ASC, time ASC')->all();
        }
        return $this->_postTimes;
    }

    public function getPostsToBeScheduled()
    {
        if(!$this->_postsToBeScheduled)
        {
            $condition['list_id'] = $this->list_id;
            if($this->config['unscheduledPostsOnly'] == true)
            {
                $condition['scheduled_time'] = null;
            }
            $this->_postsToBeScheduled = cListPost::find()->andWhere($condition)->all();
        }
        return $this->_postsToBeScheduled;
    }

    public function getStartTimeKey()
    {
        if(!isset($this->_startTimeKey))
        {
            $times = $this->getScheduleTimes();
            $i = 0;
            foreach($times as $time)
            {
                //echo $i . ' | ' . $time->weekday . ' - ' . date('N', $this->config['startDate']) . "<br />";
                if($time->weekday == date('N', $this->config['startDate']))
                {
                    //echo "Found a match at $i Done?";
                    $this->_startTimeKey = $i;
                    break;
                }
                $i++;
            }
            //no matches?
            if(!isset($this->_startTimeKey))
            {
                //echo "No match for " . date("Y-m-d", $this->config['startDate']) . "<br />";
                //die();
                //change the start date to the next day, and run this function again
                $this->config['startDate'] = $this->config['startDate'] + 86400;
                $this->_startTimeKey = $this->getStartTimeKey();
            }
        }
        return $this->_startTimeKey;
    }

    /* Increments the key each time this is called. If no more keys, then start at 0 again */
    public function getCurrentTimeKey()
    {
        if(!isset($this->_currentTimeKey))
        {
            $this->_currentTimeKey = $this->getStartTimeKey();
        }
        else
        {
            if(isset($this->getScheduleTimes()[$this->_currentTimeKey + 1]))
            {
                $this->_currentTimeKey = $this->_currentTimeKey + 1;
            }
            else
            {
                $this->_currentTimeKey = 0;
            }
        }
        //also increment the day
        $currentTime = $this->getScheduleTimes()[$this->_currentTimeKey];
        if($currentTime->weekday != $this->_previousWeekDay)
        {
            if(isset($this->_previousWeekDay))
            {
                $this->_dayCount += 1;
            }
            $this->_previousWeekDay = $currentTime->weekday;
        }
        return $this->_currentTimeKey;
    }

    public function randomMinutes()
    {
        $items[] = -15;
        $items[] = -10;
        $items[] = -5;
        $items[] = 0;
        $items[] = 5;
        $items[] = 10;
        $items[] = 15;
        return $items[rand(0, count($items)-1)] * 60;
    }

    public function run()
    {
        $posts = $this->getPostsToBeScheduled();
        foreach($posts as $post)
        {
            $timeToWorkWith = $this->getScheduleTimes()[$this->getCurrentTimeKey()];
            $date = $this->config['startDate'] + ($this->_dayCount * 86400);
            $time = strtotime("1970-01-01 $timeToWorkWith->time UTC");
            $post->scheduled_time = $date + $time;
            if($this->config['addRandomization'] == true) {
                $post->scheduled_time += $this->randomMinutes();
            }
            $post->save(false);
        }
    }

}