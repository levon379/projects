<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cTransactionNewest;

/**
 * cTransactionNewestSearch represents the model behind the search form about `common\models\cTransactionNewest`.
 */
class cTransactionNewestSearch extends cTransactionNewest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created'], 'integer'],
            [['type', 'amount', 'fee', 'net', 'details'], 'safe'],
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
        $query = cTransactionNewest::find();

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
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'fee', $this->fee])
            ->andFilterWhere(['like', 'net', $this->net])
            ->andFilterWhere(['like', 'details', $this->details]);

        return $dataProvider;
    }
}
