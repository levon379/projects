<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cScheduleTime;

/**
 * cScheduleTimeSearch represents the model behind the search form about `common\models\cScheduleTime`.
 */
class cScheduleTimeSearch extends cScheduleTime
{
    public function rules()
    {
        return [
            [['id', 'schedule_id', 'user_id', 'campaign_id', 'weekday'], 'integer'],
            [['time'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = cScheduleTime::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'class' => 'common\components\cSort'
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'schedule_id' => $this->schedule_id,
            'user_id' => $this->user_id,
            'campaign_id' => $this->campaign_id,
            'weekday' => $this->weekday,
            'time' => $this->time,
        ]);

        return $dataProvider;
    }
}
