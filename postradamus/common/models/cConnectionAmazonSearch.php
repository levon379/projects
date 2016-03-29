<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cConnectionAmazon;

/**
 * cConnectionAmazonSearch represents the model behind the search form about `common\models\cConnectionAmazon`.
 */
class cConnectionAmazonSearch extends cConnectionAmazon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'campaign_id'], 'integer'],
            [['country', 'aws_api_access_key', 'aws_api_secret_key', 'aws_associate_tag'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = cConnectionAmazon::find();

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
            'user_id' => $this->campaign_id,
        ]);

        $query->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'aws_api_access_key', $this->aws_api_access_key])
            ->andFilterWhere(['like', 'aws_api_secret_key', $this->aws_api_secret_key])
            ->andFilterWhere(['like', 'aws_associate_tag', $this->aws_associate_tag]);

        return $dataProvider;
    }
}
