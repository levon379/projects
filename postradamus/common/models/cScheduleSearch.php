<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cSchedule;

/**
 * cScheduleSearch represents the model behind the search form about `common\models\cSchedule`.
 */
class cScheduleSearch extends cSchedule
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'campaign_id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public static function find()
    {
        $query = parent::find();
        $query->where(['user_id' => Yii::$app->user->id]);
        return $query;
    }

    public function search($params)
    {
        $query = cSchedule::find();

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
            'user_id' => $this->user_id,
            'campaign_id' => $this->campaign_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
