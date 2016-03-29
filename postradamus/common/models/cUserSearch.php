<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cUser;

/**
 * cUserSearch represents the model behind the search form about `common\models\cUser`.
 */
class cUserSearch extends cUser
{
    public function rules()
    {
        return [
            [['id', 'role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'parent_id', 'auth_key', 'first_name', 'last_name', 'password_hash', 'paypal_email', 'jvzoo_pre_key', 'password_reset_token', 'email', 'plan_id', 'subscription_end_date', 'paypal_subscription_id', 'paypal_email'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = cUser::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 150,
            ],
            'sort' => [
                'class' => 'common\components\cSort'
            ]
        ]);

        $this->load($params);

        if (!($this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'role' => $this->role,
            'plan_id' => $this->plan_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        if($this->jvzoo_pre_key == 'null')
        {
            $this->jvzoo_pre_key = '';
            $query->andWhere([
                'jvzoo_pre_key' => '',
            ]);
            $query->andWhere('paypal_subscription_id LIKE "%S-%"');
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'jvzoo_pre_key', $this->jvzoo_pre_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'paypal_email', $this->paypal_email]);

        return $dataProvider;
    }
}
