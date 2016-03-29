<?php

namespace backend\components;

use common\models\cListPost;
use common\models\cScheduleTime;
use common\models\cScheduleTimePostType;
use yii\db\Expression;

class SchedulerEnhanced {

    public $schedule_id;
    public $list_id;
    public $config = [];

    private $_scheduleTimesFromDB;
    private $_postsFromDB;
    private $_startTimeKey;
    private $_currentTimeKey;
    private $_previousWeekDay;
    private $_dayCount = 0;
    private $_scheduleTimes;
    private $_postCount;
    private $_testMethodArray;
    private $_i;

    public function __construct($schedule_id, $list_id, $config = [])
    {
        $this->schedule_id = $schedule_id;
        $this->list_id = $list_id;
        $this->config = $config;
        $this->config['startDate'] = strtotime($config['startDate']);
    }

    public function getScheduleTimesFromDB()
    {
        if(!$this->_scheduleTimesFromDB)
        {
            $this->_scheduleTimesFromDB = cScheduleTime::find()->andWhere(['schedule_id' => $this->schedule_id])->orderBy('weekday ASC, time ASC')->all();
        }
        //print("<pre>");
        //print_r($this->_scheduleTimesFromDB);
        //die();
        return $this->_scheduleTimesFromDB;
    }

    public function getScheduleTimes()
    {
        if(!isset($this->_scheduleTimes))
        {
            $this->getPostsFromDB();
            $post_count = $this->_postCount;//
            for($i=0; $i<$post_count; $i++)
            {
                $key = $this->getCurrentTimeKey();
                $timeToWorkWith = $this->getScheduleTimesFromDB()[$key];
                $date = ($this->config['startDate']) + ($this->_dayCount * 86400);
                $time = strtotime("1970-01-01 $timeToWorkWith->time UTC");
                $scheduled_time = $date + $time;
                if($this->config['randomizeTime'] == 1) {
                    $scheduled_time += $this->randomMinutes();
                }

                $this->_scheduleTimes[] = [
                    'time' => $scheduled_time,
                    'key' => $key,
                    'date' => date("Y-m-d H:i", $scheduled_time),
                    'weekday' => date('l', $scheduled_time),
                    'post_types' => $timeToWorkWith->postTypes
                ];
            }
        }

        return $this->_scheduleTimes;
    }

    public function getPostsFromDB()
    {
        if(!$this->_postsFromDB)
        {
            $condition['list_id'] = $this->list_id;
            if($this->config['unscheduledPostsOnly'] == 1)
            {
                $condition['scheduled_time'] = null;
            }
            $posts = cListPost::find()->andWhere($condition)->all();
            $this->_postCount = count($posts);
            if($this->config['randomizePosts'] == 1)
            {
                shuffle($posts);
            }
            foreach($posts as $post)
            {
                if(isset($post->post_type_id) && $this->postTypeIsInSchedule($post->post_type_id)) { $id = $post->post_type_id; } else { $id = 0; }
                $this->_postsFromDB[$id][] = $post;
            }
        }
        return $this->_postsFromDB;
    }

    public function mergePostsWithTimes()
    {
/*        print("<pre>");
        print_r($this->getPostsFromDB());
        die();*/
        $id = 0;
        $times = $this->getScheduleTimes();
        //print("<pre>");
        //print_r($times);
        //die();
        if(!$times) { $times = []; }
        $this->_mergedPosts = [];
        foreach($times as $time)
        {
            $id = '';
            //this time slot could have multiple post type options, lets grab a random one, and if nothing exists in there, look for another random one and so on until we have no more left to look through

            //$groups = array_keys($this->getPostsFromDB());
            shuffle($time['post_types']);
            foreach($time['post_types'] as $post_type)
            {
                //see if we have a post for this post_type_id
                if(isset($this->getPostsFromDB()[$post_type->post_type_id][0]))
                {
                    $id = $post_type->post_type_id;
                    break;
                }
            }

            if(!$id) {
                $id = 0;
            }

            if(isset($this->getPostsFromDB()[$id]) && isset($this->getPostsFromDB()[$id][0]))
            {
                $matching_post_id = $this->getPostsFromDB()[$id][0]->id;
                //echo "Looking for post in group $id - Match found. GOOD!<br />";
            }
            else
            {
                //echo "Looking for post in group $id - No match found.<br />";
                //try to replace it with group 0 if $id = $this->findNonEmptyPostGroup(); matches a group that has time slots with $id post_type_id
                $replaced = '';

                $id = $this->findNonEmptyPostGroup();
                if($this->postTypeIsInSchedule($id) == true && isset($this->getPostsFromDB()[0][0]->id))
                {
                    $id = 0;
                }
                $matching_post_id = $this->getPostsFromDB()[$id][0]->id;
            }

            //default to blank posts?
            $this->_mergedPosts[] = [
                'time' => $time['time'],
                'post' => $matching_post_id
            ];

            if(isset($this->_postsFromDB[$id]) && isset($this->_postsFromDB[$id][0]))
            {
                unset($this->_postsFromDB[$id][0]);
                $this->_postsFromDB[$id] = array_values($this->_postsFromDB[$id]);
            }

            unset($matching_post);
        }
        //die();
       /* print("<pre>");
        print_r($this->_mergedPosts);
        print("</pre>");*/
        return $this->_mergedPosts;
    }

    public function postTypeIsInSchedule($post_type_id)
    {
        $times = cScheduleTimePostType::find()->andWhere(['schedule_id' => $this->schedule_id, 'post_type_id' => $post_type_id])->count();
        if($times > 0)
        {
            return true;
        }
        return false;
    }

    public function findNonEmptyPostGroup()
    {
        $groups = $this->getPostsFromDB();
        foreach($groups as $group_id => $group)
        {
            if(!empty($group))
            {
                return $group_id;
            }
        }
    }

    public function run()
    {
        $posts = $this->mergePostsWithTimes();
        foreach($posts as $post)
        {
            $post1 = cListPost::find()->andWhere(['id' => $post['post']])->one();
            $post1->scheduled_time = $post['time'];
            $post1->save(false);
        }
    }

    private function getStartTimeKey()
    {
        if(!isset($this->_startTimeKey))
        {
            $times = $this->getScheduleTimesFromDB();
            $i = 0;
            foreach($times as $time)
            {
                //echo $i . ' | ' . $time->weekday . ' - ' . date('N', $this->config['startDate']) . "<br />";
                if($time->weekday == date('N', ($this->config['startDate'])))
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
                //change the start date to the next day, and run this function again
                $this->config['startDate'] = ($this->config['startDate']) + 86400;
                $this->_startTimeKey = $this->getStartTimeKey();
            }
        }
        return $this->_startTimeKey;
    }

    /* Increments the key each time this is called. If no more keys, then start at 0 again */
    private function getCurrentTimeKey()
    {
        if(!isset($this->_currentTimeKey))
        {
            $this->_currentTimeKey = $this->getStartTimeKey();
        }
        else
        {
            if(isset($this->getScheduleTimesFromDB()[$this->_currentTimeKey + 1])) //next key like [2]
            {
                $this->_currentTimeKey = $this->_currentTimeKey + 1;
            }
            else
            {
                $this->_currentTimeKey = 0;
            }
        }
        $this->_i++;
        $added = 0;
        //also increment the day
        $currentTime = $this->getScheduleTimesFromDB()[$this->_currentTimeKey];
        if($currentTime->weekday != $this->_previousWeekDay || $is_first = $this->isFirstTimeInCurrentWeekday($currentTime)) //new day, dayCount+1
        {
            if(isset($this->_previousWeekDay))
            {
                if(isset($is_first) && $is_first == true && $currentTime->weekday == $this->_previousWeekDay)
                {
                    $diff = 7;
                }
                else
                {
                    if($currentTime->weekday < $this->_previousWeekDay) //wed 3 is greater than mon 1
                    {
                        $diff = $currentTime->weekday + (7 - $this->_previousWeekDay);
                    }
                    else
                    {
                        $diff = $currentTime->weekday - $this->_previousWeekDay;
                    }
                }
                $this->_dayCount += $diff;
                //echo "<h1 style='margin-left:150px;'>$diff " . 'current: ' . $currentTime->weekday . ' - ' . ' previous: ' . $this->_previousWeekDay . "</h1>";
            }
            //echo "<style>#w3 { display:none; }</style>";
            $this->_previousWeekDay = $currentTime->weekday;
        }
        return $this->_currentTimeKey;
    }

    public function isFirstTimeInCurrentWeekday($currentTime)
    {
        $t = cScheduleTime::find()->andWhere(['weekday' => $currentTime->weekday, 'schedule_id' => $currentTime->schedule_id])->orderBy('time ASC')->one();
        if($t->time == $currentTime->time)
        {
            return true;
        }
        return false;
    }

    private function randomMinutes()
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

}