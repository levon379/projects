<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cPostTemplate;

/**
 * cPostTemplateSearch represents the model behind the search form about `common\models\cPostTemplate`.
 */
class cPostTemplateSearch extends cPostTemplate
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'campaign_id', 'origin_type'], 'integer'],
            [['template', 'name', 'description'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = cPostTemplate::find();

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
            'origin_type' => $this->origin_type,
        ]);

        $query->andFilterWhere(['like', 'template', $this->template]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
