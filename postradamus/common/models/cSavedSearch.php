<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_saved_search".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $campaign_id
 * @property integer $origin_type
 * @property string $fb_type
 * @property string $search_value
 * @property string $name
 */
class cSavedSearch extends \yii\db\ActiveRecord
{

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

        $query->andWhere(['campaign_id' => (int)Yii::$app->session->get('campaign_id')]);
        return $query;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_saved_search';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'origin_type', 'search_value', 'name'], 'required'],
            [['user_id', 'campaign_id', 'origin_type'], 'integer'],
            [['search_value', 'name', 'fb_type'], 'string', 'max' => 255]
        ];
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
            'origin_type' => 'Origin Type',
            'search_value' => 'Search Value',
            'fb_type' => 'FB Type',
            'name' => 'Name',
        ];
    }
}
