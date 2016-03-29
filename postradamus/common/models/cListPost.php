<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "tbl_list_post".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $campaign_id
 * @property integer $list_id
 * @property string $name
 * @property string $text
 * @property string $link
 * @property string $image_filename
 * @property integer $post_type_id
 * @property integer $scheduled_time
 * @property string $origin_id
 * @property integer $origin_type
 * @property integer $sent_at
 * @property integer $updated_at
 * @property integer $created_at
 *
 * @property cList $list
 */
class cListPost extends \yii\db\ActiveRecord
{
    public $image;
    public $fb_page_id;
    public $wp_cat_id;
    public $board_id;
    public $title;

    const ORIGIN_UPLOAD = 1;
    const ORIGIN_FACEBOOK = 2;
    const ORIGIN_PINTEREST = 3;
    const ORIGIN_AMAZON = 4;
    const ORIGIN_YOUTUBE = 5;
    const ORIGIN_FEED = 6;
    const ORIGIN_WEBPAGE = 7;
    const ORIGIN_IMGUR = 8;
    const ORIGIN_LIST = 9;
    const ORIGIN_INSTAGRAM = 10;
    const ORIGIN_TWITTER = 11;
    const ORIGIN_TUMBLR = 12;
    const ORIGIN_REDDIT = 13;
    const ORIGIN_CSV = 14;

    const FB_STATUS = 1;
    const FB_LINK = 2;
    const FB_PHOTO = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_list_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'list_id', 'origin_type'], 'required'],
            //['origin_id', 'required', 'when' => function($model) { return $model->origin_type != self::ORIGIN_UPLOAD; }],
            [['user_id', 'list_id', 'post_type_id', 'scheduled_time', 'sent_at'], 'integer'],
            [['text', 'image_filename0', 'image_filename0_custom', 'image_filename1', 'image_filename2', 'image_filename3'], 'string'],
            [['image', 'origin_id', 'link'], 'safe'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className()
            ],
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

    public function getOrigin_Image_Url()
    {
        if($this->origin_type == 1)
        {
            return 'images/icons/hd-icon.fw.png';
        }
        if($this->origin_type == 2)
        {
            return 'images/icons/facebook-icon.fw.png';
        }
        if($this->origin_type == 3)
        {
            return 'images/icons/pinterest-icon.fw.png';
        }
        if($this->origin_type == 4)
        {
            return 'images/icons/amazon-icon.fw.png';
        }
        if($this->origin_type == 5)
        {
            return 'images/icons/youtube-icon.fw.png';
        }
        if($this->origin_type == 6)
        {
            return 'images/icons/rss-icon.fw.png';
        }
        if($this->origin_type == 7)
        {
            return 'images/icons/ff-icon.fw.png';
        }
        if($this->origin_type == 8)
        {
            return 'images/icons/imgur-icon.fw.png';
        }
        if($this->origin_type == 9)
        {
            return 'images/icons/hd-icon.fw.png';
        }
        if($this->origin_type == 10)
        {
            return 'images/icons/instagram-icon.fw.png';
        }
        if($this->origin_type == 11)
        {
            return 'images/icons/twitter-icon.fw.png';
        }
        if($this->origin_type == 12)
        {
            return 'images/icons/tumblr-icon.fw.png';
        }
        if($this->origin_type == 13)
        {
            return 'images/icons/reddit-icon.fw.png';
        }
        if($this->origin_type == 14)
        {
            return 'images/icons/hd-icon.fw.png';
        }
    }

    public static function getOriginIdFromName($name)
    {
        if(strtolower($name) == 'upload')
        {
            return 1;
        }
        if(strtolower($name) == 'facebook')
        {
            return 2;
        }
        if(strtolower($name) == 'pinterest')
        {
            return 3;
        }
        if(strtolower($name) == 'amazon')
        {
            return 4;
        }
        if(strtolower($name) == 'youtube')
        {
            return 5;
        }
        if(strtolower($name) == 'feed')
        {
            return 6;
        }
        if(strtolower($name) == 'webpage')
        {
            return 7;
        }
        if(strtolower($name) == 'imgur')
        {
            return 8;
        }
        if(strtolower($name) == 'list')
        {
            return 9;
        }
        if(strtolower($name) == 'instagram')
        {
            return 10;
        }
        if(strtolower($name) == 'twitter')
        {
            return 11;
        }
        if(strtolower($name) == 'tumblr')
        {
            return 12;
        }
        if(strtolower($name) == 'reddit')
        {
            return 13;
        }
        if(strtolower($name) == 'csv')
        {
            return 14;
        }
    }

    public static function getOriginNameFromId($id)
    {
        if($id == 1)
        {
            return 'Upload';
        }
        if($id == 2)
        {
            return 'Facebook';
        }
        if($id == 3)
        {
            return 'Pinterest';
        }
        if($id == 4)
        {
            return 'Amazon';
        }
        if($id == 5)
        {
            return 'Youtube';
        }
        if($id == 6)
        {
            return 'Feed';
        }
        if($id == 7)
        {
            return 'Webpage';
        }
        if($id == 8)
        {
            return 'Imgur';
        }
        if($id == 9)
        {
            return 'Existing List';
        }
        if($id == 10)
        {
            return 'Instagram';
        }
        if($id == 11)
        {
            return 'Twitter';
        }
        if($id == 12)
        {
            return 'Tumblr';
        }
        if($id == 13)
        {
            return 'Reddit';
        }
        if($id == 14)
        {
            return 'CSV Import';
        }
    }

    public function getOrigin_Name()
    {
        if($this->origin_type == 1)
        {
            return 'Upload';
        }
        if($this->origin_type == 2)
        {
            return 'Facebook';
        }
        if($this->origin_type == 3)
        {
            return 'Pinterest';
        }
        if($this->origin_type == 4)
        {
            return 'Amazon';
        }
        if($this->origin_type == 5)
        {
            return 'Youtube';
        }
        if($this->origin_type == 6)
        {
            return 'Feed';
        }
        if($this->origin_type == 7)
        {
            return 'Webpage';
        }
        if($this->origin_type == 8)
        {
            return 'Imgur';
        }
        if($this->origin_type == 9)
        {
            return 'Existing List';
        }
        if($this->origin_type == 10)
        {
            return 'Instagram';
        }
        if($this->origin_type == 11)
        {
            return 'Twitter';
        }
        if($this->origin_type == 12)
        {
            return 'Tumblr';
        }
        if($this->origin_type == 13)
        {
            return 'Reddit';
        }
        if($this->origin_type == 14)
        {
            return 'CSV Import';
        }
    }

    public function convertImageFilenameToCustom($filename)
    {
        $parts = pathinfo($filename);
        $file = $parts['filename'] . '_custom.png';
        return $file;
    }

    public function getImage_Url($index = 0)
    {
        if($index == 0)
        {
            if($this->image_filename0 != '')
            {
                if($this->image_filename0_custom == '')
                    return Yii::$app->params['imageUrl'] . 'posts/' . $this->user_id . '/' . $this->list_id . '/' . $this->image_filename0;
                else
                    return Yii::$app->params['imageUrl'] . 'posts/' . $this->user_id . '/' . $this->list_id . '/' . $this->convertImageFilenameToCustom($this->image_filename0);
            }
        }
        if($index == 1)
        {
            if($this->image_filename1 != '')
            {
                return Yii::$app->params['imageUrl'] . 'posts/' . $this->user_id . '/' . $this->list_id . '/' . $this->image_filename1;
            }
        }
        if($index == 2)
        {
            if($this->image_filename2 != '')
            {
                return Yii::$app->params['imageUrl'] . 'posts/' . $this->user_id . '/' . $this->list_id . '/' . $this->image_filename2;
            }
        }
        if($index == 3)
        {
            if($this->image_filename3 != '')
            {
                return Yii::$app->params['imageUrl'] . 'posts/' . $this->user_id . '/' . $this->list_id . '/' . $this->image_filename3;
            }
        }
        return ;
    }

    public function getImage_Filename_With_Path($index = 0)
    {
        if($index == 0)
        {
            if($this->image_filename0 != '')
            {
                if($this->image_filename0_custom == '')
                    return Yii::$app->params['imagePath'] . 'posts/' . $this->user_id . '/' . $this->list_id . '/' . $this->image_filename0;
                else
                    return Yii::$app->params['imagePath'] . 'posts/' . $this->user_id . '/' . $this->list_id . '/' . $this->convertImageFilenameToCustom($this->image_filename0);
            }
        }
        if($index == 1)
        {
            if($this->image_filename1 != '')
            {
                return Yii::$app->params['imagePath'] . 'posts/' . $this->user_id . '/' . $this->list_id . '/' . $this->image_filename1;
            }
        }
        if($index == 2)
        {
            if($this->image_filename2 != '')
            {
                return Yii::$app->params['imagePath'] . 'posts/' . $this->user_id . '/' . $this->list_id . '/' . $this->image_filename2;
            }
        }
        if($index == 3)
        {
            if($this->image_filename3 != '')
            {
                return Yii::$app->params['imagePath'] . 'posts/' . $this->user_id . '/' . $this->list_id . '/' . $this->image_filename3;
            }
        }
        return ;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'list_id' => 'List',
            'name' => 'Name',
            'text' => 'Text',
            'image_filename0' => 'Image',
            'post_type_id' => 'Post Type',
            'scheduled_time' => 'Scheduled Time',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    public function getPostCount()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasMany(cListPost::className(), ['list_id' => 'id'])->count();
    }

    public function getPostMeta()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasMany(cListPostMeta::className(), ['list_id' => 'id']);
    }

    public function getPostType()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasOne(cPostType::className(), ['id' => 'post_type_id']);
    }

    /* Retrieves all posts we've sent (or attempted) */
    public function getListSentPost()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasMany(cListSentPost::className(), ['list_post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(cList::className(), ['id' => 'list_id']);
    }
	
	public function afterDelete(){
        parent::afterDelete();
		$listId=$this->list_id;
		
		@unlink(Yii::$app->params['imagePath'] . 'posts/' .Yii::$app->user->id . '/' . $listId . '/' . $this->image_filename0);
        @unlink(Yii::$app->params['imagePath'] . 'posts/' .Yii::$app->user->id . '/' . $listId . '/' . $this->image_filename1);
        @unlink(Yii::$app->params['imagePath'] . 'posts/' .Yii::$app->user->id . '/' . $listId . '/' . $this->image_filename2);
        @unlink(Yii::$app->params['imagePath'] . 'posts/' .Yii::$app->user->id . '/' . $listId . '/' . $this->image_filename3);
    }
}