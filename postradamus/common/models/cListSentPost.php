<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_list_sent_post".
 *
 * @property integer $id
 * @property integer $list_sent_id
 * @property integer $list_post_id
 * @property integer $list_id
 * @property integer $user_id
 * @property integer $success
 * @property string $post_id
 * @property string $error
 * @property integer $sent
 * @property integer $updated_at
 * @property integer $created_at
 */
class cListSentPost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_list_sent_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['list_sent_id', 'list_post_id', 'list_id', 'user_id', 'success', 'error', 'sent'], 'required'],
            [['error', 'post_id'], 'safe'],
            [['list_sent_id', 'list_post_id', 'list_id', 'user_id', 'success', 'sent', 'updated_at', 'created_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'list_sent_id' => 'List Sent ID',
            'list_post_id' => 'List Post ID',
            'list_id' => 'List ID',
            'user_id' => 'User ID',
            'success' => 'Status',
            'post_id' => 'Post ID',
            'error' => 'Errors?',
            'sent' => 'Sent',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    public function getPost_Url()
    {
        if($this->listSent->target == cListSent::TARGET_PINTEREST)
        {
            return 'http://www.pinterest.com/pin/' . $this->post_id;
        }
        if($this->listSent->target == cListSent::TARGET_FACEBOOK)
        {
            return 'http://www.fb.com/' . $this->post_id;
        }
        if($this->listSent->target == cListSent::TARGET_WORDPRESS)
        {
            $user = cUser::find()->where(['id' => $this->user_id])->one();
            return $user->getWordpressConnection('xml_rpc_url', $this->listSent->campaign_id) . '?p=' . $this->post_id;
        }
    }

    public static function isSent($list_sent_id, $post_id)
    {
        $success_exists = cListSentPost::find()->where(['list_post_id' => $post_id, 'list_sent_id' => $list_sent_id, 'success' => 1])->exists();
        if($success_exists)
        {
            return true;
        }
        $total_attempts = cListSentPost::find()->where(['list_post_id' => $post_id, 'list_sent_id' => $list_sent_id])->count();
        if($total_attempts >= 3) //tried but errors possibly
        {
            return true;
        }
        return false;
    }

    public function getListSent()
    {
        return $this->hasOne(cListSent::className(), ['id' => 'list_sent_id']);
    }

}
