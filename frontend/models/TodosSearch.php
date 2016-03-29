<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Todos;

/**
 * TodosSearch represents the model behind the search form about `frontend\models\Todos`.
 */
class TodosSearch extends Todos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'priority', 'todolist_id', 'user_id', 'complete'], 'integer'],
            [['todo', 'details', 'due_on', 'created_at', 'updated_at'], 'safe'],
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
        $query = Todos::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'priority' => $this->priority,
            'todolist_id' => $this->todolist_id,
            'user_id' => $this->user_id,
            'due_on' => $this->due_on,
            'complete' => $this->complete,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'todo', $this->todo])
            ->andFilterWhere(['like', 'details', $this->details]);

        return $dataProvider;
    }
}
