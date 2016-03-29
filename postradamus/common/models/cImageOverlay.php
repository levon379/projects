<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_image_overlay".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $campaign_id
 * @property string $image_filename
 * @property integer $position
 */
class cImageOverlay extends \yii\db\ActiveRecord
{
    public $image, $campaigns;

    const POSITION_MIDDLE_LEFT = 1;
    const POSITION_MIDDLE_RIGHT = 2;
    const POSITION_TOP_LEFT = 3;
    const POSITION_TOP_RIGHT = 4;
    const POSITION_TOP_MIDDLE = 5;
    const POSITION_BOTTOM_LEFT = 6;
    const POSITION_BOTTOM_MIDDLE = 7;
    const POSITION_BOTTOM_RIGHT = 8;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_image_overlay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'campaign_id', 'campaigns', 'position'], 'integer'],
            [['image'], 'safe'],
            [['image_filename'], 'string', 'max' => 255]
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

    public function getImage_Url()
    {
        if($this->image_filename != '')
            return Yii::$app->params['imageUrl'] . 'overlays/' . $this->user_id . '/' . $this->image_filename;

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
            'campaign_id' => 'Campaign ID',
            'image_filename' => 'Image Url',
            'position' => 'Position',
        ];
    }

    public function afterFind()
    {
        if($this->campaign_id == 0)
        {
            $this->campaigns = 1;
        }
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->campaigns == 1)
            {
                $this->campaign_id = 0;
            }
            else
            {
                $this->campaign_id = (int)Yii::$app->session->get('campaign_id');
            }
            return true;
        } else {
            return false;
        }
    }
}
