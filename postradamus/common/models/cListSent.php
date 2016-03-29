<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "tbl_list_sent".
 *
 * @property integer $id
 * @property integer $list_id
 * @property integer $user_id
 * @property integer $campaign_id
 * @property integer $target
 * @property integer $started
 * @property integer $ended
 * @property integer $updated_at
 * @property integer $created_at
 */
class cListSent extends \yii\db\ActiveRecord
{
    const TARGET_FACEBOOK = 1;
    const TARGET_PINTEREST = 2;
    const TARGET_WORDPRESS = 3;

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('UNIX_TIMESTAMP()'),
            ],
        ];
    }

    public function getTarget_Name()
    {
        if($this->target == self::TARGET_FACEBOOK)
        {
            return 'facebook';
        }
        if($this->target == self::TARGET_PINTEREST)
        {
            return 'pinterest';
        }
        if($this->target == self::TARGET_WORDPRESS)
        {
            return 'wordpress';
        }
    }

    public function getMain_Meta()
    {
        if($this->target == self::TARGET_FACEBOOK)
        {
            foreach($this->listSentMeta as $meta)
            {
                if($meta->key == 'page_name' || $meta->key == 'group_name')
                return $meta->value;
            }
        }
        if($this->target == self::TARGET_PINTEREST)
        {
            foreach($this->listSentMeta as $meta)
            {
                if($meta->key == 'board_name')
                    return $meta->value;
            }
        }
        if($this->target == self::TARGET_WORDPRESS)
        {
            foreach($this->listSentMeta as $meta)
            {
                if($meta->key == 'blog_name')
                    return $meta->value;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_list_sent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['list_id', 'user_id', 'campaign_id', 'target', 'started', 'ended', 'updated_at', 'created_at'], 'required'],
            [['list_id', 'user_id', 'campaign_id', 'target', 'started', 'ended', 'updated_at', 'created_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'list_id' => 'List ID',
            'user_id' => 'User ID',
            'campaign_id' => 'Campaign ID',
            'target' => 'Target',
            'started' => 'Started',
            'ended' => 'Ended',
            'updated_at' => 'Updated',
            'created_at' => 'Created',
        ];
    }

    public function getListSentMeta()
    {
        return $this->hasMany(cListSentMeta::className(), ['list_sent_id' => 'id']);
    }

    public function getListSentPost()
    {
        return $this->hasMany(cListSentPost::className(), ['list_sent_id' => 'id']);
    }

    public function getList()
    {
        return $this->hasOne(cList::className(), ['id' => 'list_id']);
    }
}
