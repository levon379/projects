<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cListPost;

/**
 * cListPostSearch represents the model behind the search form about `common\models\cListPost`.
 */
class cListPostSearch extends cListPost
{
    public $scheduled = 0;
    public $is_link_post = 2;
    public function rules()
    {
        return [
            [['id', 'user_id', 'list_id', 'post_type_id', 'scheduled_time', 'updated_at', 'created_at'], 'integer'],
            [['name', 'text', 'image_filename0', 'image_filename1', 'image_filename2', 'image_filename3', 'scheduled', 'list_id', 'is_link_post'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = cListPost::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'class' => 'common\components\cSort',
                'attributes' => [
                    'name' => [
                        'label' => 'Name',
                        'default' => SORT_DESC,
                    ],
                    'origin_type' => [
                        'label' => 'Origin',
                        'default' => SORT_ASC,
                    ],
                    'post_type_id' => [
                        'label' => 'Post Type',
                        'default' => SORT_ASC,
                    ],
                    'scheduled_time' => [
                        'label' => 'Scheduled Time',
                        'default' => SORT_ASC,
                    ],
                    'updated_at' => [
                        'label' => 'Last Updated',
                        'default' => SORT_ASC,
                    ],
                    'created_at' => [
                        'label' => 'Created Date',
                        'default' => SORT_ASC,
                    ],
                ],
                'defaultOrder' => [
                    'scheduled_time' => SORT_ASC,
                    'origin_type' => SORT_ASC
                ],
            ],
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'list_id' => $this->list_id,
            'post_type_id' => $this->post_type_id,
            'scheduled_time' => $this->scheduled_time,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        if($this->scheduled == 1)
        {
            $query->andWhere('scheduled_time IS NOT NULL');
        }

        if($this->scheduled == 2)
        {
            $query->andWhere('scheduled_time IS NULL');
        }

        if($this->is_link_post == '1')
        {
            $query->andWhere('link != ""');
        }

        if($this->is_link_post == '0')
        {
            $query->andWhere('link = ""');
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'image_filename0', $this->image_filename0])
            ->andFilterWhere(['like', 'image_filename1', $this->image_filename1])
            ->andFilterWhere(['like', 'image_filename2', $this->image_filename2])
            ->andFilterWhere(['like', 'image_filename4', $this->image_filename3]);

        return $dataProvider;
    }
}
