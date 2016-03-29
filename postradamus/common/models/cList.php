<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use backend\components\Common;
/**
 * This is the model class for table "tbl_list".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $deleted
 * @property integer $internal_scheduler
 * @property integer $sent_at
 * @property integer $updated_at
 * @property integer $created_at
 *
 * @property cListPost $list
 */
class cList extends \yii\db\ActiveRecord
{
    public $campaigns;

    const STATUS_NOT_READY = 1;
    const STATUS_READY = 2;
    const STATUS_SENDING = 3;
    const STATUS_SENT = 4;

    public static function tableName()
    {
        return 'tbl_list';
    }

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['post_count', 'scheduled_count']);
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id', 'name'], 'unique', 'targetAttribute' => ['user_id', 'name'], 'on' => 'create'],
            [['user_id', 'campaign_id', 'campaigns', 'deleted', 'internal_scheduler', 'sent_at', 'updated_at', 'created_at'], 'integer'],
            [['user_id'], 'safe'],
            [['campaign_id'], 'default', 'value' => 0],
            [['name'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'campaign_id' => 'Campaign',
            'user_id' => 'User ID',
            'name' => 'Name',
            'deleted' => 'Deleted',
            'updated_at' => 'Last Updated',
            'created_at' => 'Created',
        ];
    }

    public static function find()
    {
        $query = parent::find();
        $query->select("tbl_list.*, COUNT(tbl_list_post.id) AS post_count");
        $query->leftJoin('tbl_list_post', 'tbl_list_post.list_id = tbl_list.id');

        if(Yii::$app->user->id)
        {
            if(Yii::$app->user->identity->getField('parent_id') != 0)
            {
                $query->andWhere(['or', 'tbl_list.user_id=' . Yii::$app->user->id, 'tbl_list.user_id=' . Yii::$app->user->identity->getField('parent_id')]);
            }
            else
            {
                $sub_accounts = \common\models\cUser::find()->where(['parent_id' => Yii::$app->user->id])->all();
                $user_ids = [];
                foreach($sub_accounts as $user)
                {
                    $user_ids[] = $user->id;
                }
                $query->andWhere(['or', 'tbl_list.user_id=' . Yii::$app->user->id, ['in', 'tbl_list.user_id', $user_ids]]);
            }
            $query->andWhere(['or', 'tbl_list.campaign_id=' . (int)Yii::$app->session->get('campaign_id'), 'tbl_list.campaign_id=0']);
        }

        $query->andWhere(['tbl_list.deleted' => 0]);
        $query->groupBy(['tbl_list.id']);
        return $query;
    }

    public static function findNotReady()
    {
        if(!$userTimezone = Yii::$app->user->identity->getSetting('timezone'))
        {
            $userTimezone = 'America/Los_Angeles';
        }
        $offset = Yii::$app->postradamus->get_timezone_offset($userTimezone);
        $query = parent::find();
        $query->select("tbl_list.*, (SELECT COUNT(tbl_list_post.id)
                                     FROM tbl_list_post
                                     WHERE tbl_list_post.list_id = tbl_list.id) AS post_count,
                                    (SELECT COUNT(tbl_list_post.id)
                                    FROM tbl_list_post
                                    WHERE tbl_list_post.list_id = tbl_list.id AND scheduled_time IS NOT NULL AND scheduled_time > UNIX_TIMESTAMP() - $offset) AS scheduled_count
");
        $query->leftJoin('tbl_list_sent', 'tbl_list_sent.list_id = tbl_list.id');
        //$query->leftJoin('tbl_list_post', 'tbl_list_post.list_id = tbl_list.id');

        if(Yii::$app->user->identity->getField('parent_id') != 0)
        {
            $query->andWhere(['or', 'tbl_list.user_id=' . Yii::$app->user->id, 'tbl_list.user_id=' . Yii::$app->user->identity->getField('parent_id')]);
        }
        else
        {
            $sub_accounts = \common\models\cUser::find()->where(['parent_id' => Yii::$app->user->id])->all();
            $user_ids = [];
            foreach($sub_accounts as $user)
            {
                $user_ids[] = $user->id;
            }
            $query->andWhere(['or', 'tbl_list.user_id=' . Yii::$app->user->id, ['in', 'tbl_list.user_id', $user_ids]]);
        }

        $query->andWhere(['tbl_list.deleted' => 0]);
        $query->andWhere(['or', 'tbl_list.campaign_id=' . (int)Yii::$app->session->get('campaign_id'), 'tbl_list.campaign_id=0']);
        $query->groupBy(['tbl_list.id']);
        $query->andWhere('tbl_list_sent.id IS NULL AND tbl_list.sent_at = 0');
        $query->having("post_count = 0 OR scheduled_count != post_count");
        return $query;
    }

    public static function findReady()
    {
        if(!$userTimezone = Yii::$app->user->identity->getSetting('timezone'))
        {
            $userTimezone = 'America/Los_Angeles';
        }
        $offset = Yii::$app->postradamus->get_timezone_offset($userTimezone);

        $query = parent::find();
        $query->select("tbl_list.*, (SELECT COUNT(tbl_list_post.id)
                                     FROM tbl_list_post
                                     WHERE tbl_list_post.list_id = tbl_list.id) AS post_count,
                                    (SELECT COUNT(tbl_list_post.id)
                                    FROM tbl_list_post
                                    WHERE tbl_list_post.list_id = tbl_list.id AND scheduled_time IS NOT NULL AND scheduled_time > UNIX_TIMESTAMP() - $offset) AS scheduled_count");
        //$query->leftJoin('tbl_list_post', 'tbl_list_post.list_id = tbl_list.id');
        $query->leftJoin('tbl_list_sent', 'tbl_list_sent.list_id = tbl_list.id');

        if(Yii::$app->user->identity->getField('parent_id') != 0)
        {
            $query->andWhere(['or', 'tbl_list.user_id=' . Yii::$app->user->id, 'tbl_list.user_id=' . Yii::$app->user->identity->getField('parent_id')]);
        }
        else
        {
            $sub_accounts = \common\models\cUser::find()->where(['parent_id' => Yii::$app->user->id])->all();
            $user_ids = [];
            foreach($sub_accounts as $user)
            {
                $user_ids[] = $user->id;
            }
            $query->andWhere(['or', 'tbl_list.user_id=' . Yii::$app->user->id, ['in', 'tbl_list.user_id', $user_ids]]);
        }

        $query->andWhere(['tbl_list.deleted' => 0]);
        $query->andWhere(['or', 'tbl_list.campaign_id=' . (int)Yii::$app->session->get('campaign_id'), 'tbl_list.campaign_id=0']);
        $query->andWhere('tbl_list_sent.id IS NULL AND tbl_list.sent_at = 0');
        $query->groupBy(['tbl_list.id']);
        $query->having("post_count > 0 AND scheduled_count = post_count");
        return $query;
    }

    public static function findSent()
    {
        $query = parent::find();
        $query->select("tbl_list.*, tbl_list_sent.id AS tbl_list_sent_id, (SELECT COUNT(tbl_list_post.id)
                                     FROM tbl_list_post
                                     WHERE tbl_list_post.list_id = tbl_list.id) AS post_count,
                                    (SELECT COUNT(tbl_list_post.id)
                                    FROM tbl_list_post
                                    WHERE tbl_list_post.list_id = tbl_list_sent.list_id AND scheduled_time IS NOT NULL AND scheduled_time > UNIX_TIMESTAMP()) AS scheduled_count");
        //$query->leftJoin('tbl_list_post', 'tbl_list_post.list_id = tbl_list.id');
        $query->leftJoin('tbl_list_sent', 'tbl_list_sent.list_id = tbl_list.id AND ((SELECT COUNT(tbl_list_sent_post.id)
                                    FROM tbl_list_sent_post
                                    LEFT JOIN tbl_list_sent AS tbl_list_sent2 ON tbl_list_sent2.id = tbl_list_sent_post.list_sent_id
                                    WHERE tbl_list_sent_post.list_id = tbl_list.id AND tbl_list_sent_post.list_sent_id = tbl_list_sent2.id AND success = 1 AND tbl_list_sent2.id = tbl_list_sent.id) = (SELECT COUNT(tbl_list_post.id)
                                     FROM tbl_list_post
                                     WHERE tbl_list_post.list_id = tbl_list.id))');

        if(Yii::$app->user->identity->getField('parent_id') != 0)
        {
            $query->andWhere(['or', 'tbl_list.user_id=' . Yii::$app->user->id, 'tbl_list.user_id=' . Yii::$app->user->identity->getField('parent_id')]);
        }
        else
        {
            $sub_accounts = \common\models\cUser::find()->where(['parent_id' => Yii::$app->user->id])->all();
            $user_ids = [];
            foreach($sub_accounts as $user)
            {
                $user_ids[] = $user->id;
            }
            $query->andWhere(['or', 'tbl_list.user_id=' . Yii::$app->user->id, ['in', 'tbl_list.user_id', $user_ids]]);
        }

        $query->andWhere(['tbl_list.deleted' => 0]);
        //$query->andWhere('1=0 OR sent_at != 0');
        $query->andWhere(['or', 'tbl_list.campaign_id=' . (int)Yii::$app->session->get('campaign_id'), 'tbl_list.campaign_id=0']);
        $query->groupBy(['tbl_list.id']);
        $query->having('tbl_list.sent_at != 0 OR tbl_list_sent.id IS NOT NULL');
        return $query;
    }

    public static function findSending()
    {
        /* A list is "sending" if a tbl_list_sent entry exists with started!=0 AND ended=0 */
        $query = parent::find();
        $query->select("tbl_list.*,
                                    (SELECT COUNT(tbl_list_post.id)
                                     FROM tbl_list_post
                                     WHERE tbl_list_post.list_id = tbl_list_sent.list_id) AS post_count,
                                    (SELECT COUNT(tbl_list_post.id)
                                     FROM tbl_list_post
                                     WHERE tbl_list_post.list_id = tbl_list_sent.list_id AND scheduled_time IS NOT NULL AND scheduled_time > UNIX_TIMESTAMP()) AS scheduled_count");
        $query->innerJoin('tbl_list_sent', 'tbl_list_sent.list_id = tbl_list.id AND tbl_list_sent.ended = 0');

        //Multi-user support
        if(Yii::$app->user->identity->getField('parent_id') != 0)
        {
            $query->andWhere(['or', 'tbl_list.user_id=' . Yii::$app->user->id, 'tbl_list.user_id=' . Yii::$app->user->identity->getField('parent_id')]);
        }
        else
        {
            $sub_accounts = \common\models\cUser::find()->where(['parent_id' => Yii::$app->user->id])->all();
            $user_ids = [];
            foreach($sub_accounts as $user)
            {
                $user_ids[] = $user->id;
            }
            $query->andWhere(['or', 'tbl_list.user_id=' . Yii::$app->user->id, ['in', 'tbl_list.user_id', $user_ids]]);
        }

        $query->andWhere(['tbl_list.deleted' => 0]);
        $query->andWhere(['or', 'tbl_list.campaign_id=' . (int)Yii::$app->session->get('campaign_id'), 'tbl_list.campaign_id=0']);
        $query->andWhere('((SELECT COUNT(tbl_list_sent_post.id)
                                    FROM tbl_list_sent_post
                                    LEFT JOIN tbl_list_sent AS tbl_list_sent2 ON tbl_list_sent2.id = tbl_list_sent_post.list_sent_id
                                    WHERE tbl_list_sent_post.list_id = tbl_list.id AND tbl_list_sent_post.list_sent_id = tbl_list_sent2.id AND success = 1 AND tbl_list_sent2.id = tbl_list_sent.id) < (SELECT COUNT(tbl_list_post.id)
                                     FROM tbl_list_post
                                     WHERE tbl_list_post.list_id = tbl_list.id) AND tbl_list.sent_at = 0)');
        $query->groupBy(['tbl_list.id']);
        //$query->andWhere('tbl_list.internal_scheduler = 1 AND tbl_list.sent_at = 0');
        return $query;
    }

    public function getStatus()
    {
        $not_ready_lists = $this->findNotReady();
        foreach($not_ready_lists as $list)
        {
            if($list->id == $this->id)
            {
                return self::STATUS_NOT_READY;
            }
        }
        $ready_lists = $this->findReady();
        foreach($ready_lists as $list)
        {
            if($list->id == $this->id)
            {
                return self::STATUS_READY;
            }
        }
        $sending_lists = $this->findSending();
        foreach($sending_lists as $list)
        {
            if($list->id == $this->id)
            {
                return self::STATUS_SENDING;
            }
        }
        $sent_lists = $this->findSent();
        foreach($sent_lists as $list)
        {
            if($list->id == $this->id)
            {
                return self::STATUS_SENT;
            }
        }
        return false;
    }

    public function getTo_Page_Name()
    {
        if($this->to_page != '')
        {
            return $this->to_page;
        }
        return ;
    }

    public static function findCronSending()
    {
        $query = parent::find();
        /*$query->select("tbl_list.*, tbl_list_sent.id AS id2, (SELECT COUNT(tbl_list_post.id)
                                     FROM tbl_list_post
                                     WHERE tbl_list_post.list_id = tbl_list.id) AS post_count,
                                    (SELECT COUNT(tbl_list_post.id)
                                    FROM tbl_list_post
                                    WHERE tbl_list_post.list_id = tbl_list.id AND scheduled_time IS NOT NULL AND scheduled_time > UNIX_TIMESTAMP()) AS scheduled_count,
                                    (SELECT COUNT(tbl_list_sent_post.id)
                                    FROM tbl_list_sent_post
                                    LEFT JOIN tbl_list_sent ON tbl_list_sent.id = tbl_list_sent_post.list_sent_id
                                    WHERE tbl_list_sent_post.list_id = tbl_list.id AND tbl_list_sent_post.list_sent_id = tbl_list_sent.id AND success = 1) AS sent_count");
        */
        $query->leftJoin('tbl_list_sent', 'tbl_list_sent.list_id = tbl_list.id AND tbl_list_sent.ended = 0');
        $query->andWhere(['tbl_list.deleted' => 0]);
        $query->andWhere('tbl_list_sent.ended IS NOT NULL');
        $query->andWhere('((SELECT COUNT(tbl_list_sent_post.id)
                                    FROM tbl_list_sent_post
                                    LEFT JOIN tbl_list_sent AS tbl_list_sent2 ON tbl_list_sent2.id = tbl_list_sent_post.list_sent_id
                                    WHERE tbl_list_sent_post.list_id = tbl_list.id AND tbl_list_sent_post.list_sent_id = tbl_list_sent2.id AND success = 1 AND tbl_list_sent2.id = tbl_list_sent.id) < (SELECT COUNT(tbl_list_post.id)
                                     FROM tbl_list_post
                                     WHERE tbl_list_post.list_id = tbl_list.id) AND tbl_list.sent_at = 0)');
        //$query->groupBy(['tbl_list.id']);
        //$query->andWhere('tbl_list.internal_scheduler = 1 AND tbl_list.sent_at = 0');
        return $query;
    }

    public function getName_with_count_and_dates()
    {
        $dateRange = '[{Start Date} - {End Date}]' ;
        $post = \common\models\cListPost::find()->where(['list_id'=> $this->id])->andWhere("scheduled_time != 0")->orderBy('scheduled_time ASC')->one();
        if($post->scheduled_time != 0){
            $dateRange = str_replace( '{Start Date}',date(Yii::$app->postradamus->get_user_date_format(), $post->scheduled_time),$dateRange);
        }
        else{
            $dateRange = str_replace( '{Start Date}','NA',$dateRange);
        }
        $post = \common\models\cListPost::find()->where(['list_id'=> $this->id])->andWhere("scheduled_time != 0")->orderBy('scheduled_time DESC')->one();
        if($post->scheduled_time != 0){
            $dateRange = str_replace( '{End Date}',date(Yii::$app->postradamus->get_user_date_format(), $post->scheduled_time),$dateRange);
        }
        else{
            $dateRange = str_replace( '{End Date}','NA',$dateRange);
        }

        if($dateRange == "[NA - NA]")
        {
            $dateRange = "[Unscheduled]";
        }
        return $this->name . ' (' . $this->post_count . ')' . ' ' . $dateRange;
    }

    public function getName_with_count_and_ready()
    {
        return $this->name . ' (' . $this->post_count . ') (scheduled: ' . (int)$this->scheduled_count . ')';
    }

    public function getPostCount()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasMany(cListPost::className(), ['list_id' => 'id'])->count();
    }

    public function getPosts()
    {
        return $this->hasMany(cListPost::className(), ['list_id' => 'id']);
    }

    public function getListSent()
    {
        return $this->hasMany(cListSent::className(), ['list_id' => 'id']);
    }

    public function init()
    {
        if($this->isNewRecord)
        {
            $this->campaign_id = (int)Yii::$app->session->get('campaign_id');
        }
        parent::init();
    }
	
	public function afterDelete(){
        parent::afterDelete();
		$listId=$this->id;
		Common::removeDir(Yii::$app->params['imagePath'].'posts/'.Yii::$app->user->id. '/'.$listId);
	}

}
