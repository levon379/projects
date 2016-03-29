<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cList;
use common\components\cSort;

/**
 * cListSearch represents the model behind the search form about `common\models\cList`.
 */
class cListSearch extends cList
{
    const STATUS_NOT_READY = 0;
    const STATUS_READY = 1;
    const STATUS_SENT = 2;
    const STATUS_SENDING = 3;

    public $post_count;

    public function rules()
    {
        return [
            [['id', 'user_id', 'campaign_id', 'deleted', 'updated_at', 'created_at'], 'integer'],
            [['name', 'post_count', 'internal_scheduler'], 'safe'],
        ];
    }

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['tbl_list.post_count']);
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        if($params['cListSearch']['status'] == cListSearch::STATUS_NOT_READY)
            $query = cList::findNotReady();

        if($params['cListSearch']['status'] == cListSearch::STATUS_READY)
            $query = cList::findReady();

        if($params['cListSearch']['status'] == cListSearch::STATUS_SENT)
            $query = cList::findSent();

        if($params['cListSearch']['status'] == cListSearch::STATUS_SENDING)
            $query = cList::findSending();


        //$query->asArray();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'class' => 'common\components\cSort'
            ]
        ]);

        /*
        // enable sorting for the related column
        $dataProvider->sort->attributes['list.postCount'] = [
            'asc' => ['list.postCount' => SORT_ASC],
            'desc' => ['list.postCount' => SORT_DESC],
        ];
        */

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tbl_list.id' => $this->id,
            'tbl_list.updated_at' => $this->updated_at,
            'tbl_list.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'tbl_list.name', $this->name]);

        return $dataProvider;
    }
}
