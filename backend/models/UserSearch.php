<?php

namespace backend\models;

use DateTime;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form of `backend\models\User`.
 */
class UserSearch extends User
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'password_reset_token', 'email', 'roleName', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = User::find()->join('LEFT JOIN', 'auth_assignment', '"user".id = cast( auth_assignment.user_id as integer)');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['roleName'] = [
            'asc' => ['auth_assignment.item_name' => SORT_ASC],
            'desc' => ['auth_assignment.item_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'username', $this->username])
            ->andFilterWhere(['ilike', 'auth_key', $this->auth_key])
            ->andFilterWhere(['ilike', 'password_hash', $this->password_hash])
            ->andFilterWhere(['ilike', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['auth_assignment.item_name' => $this->roleName])
            ->andFilterWhere(['ilike', 'verification_token', $this->verification_token]);
        if ($this->created_at) {
            $date = new DateTime($this->created_at);
            $start = $date->getTimestamp();
            $query->andFilterWhere(['between', 'user.created_at', $start, $start + 86400]);
        }
        if ($this->updated_at) {
            $date = new DateTime($this->updated_at);
            $start = $date->getTimestamp();
            $query->andFilterWhere(['between', 'user.updated_at', $start, $start + 86400]);
        }
        return $dataProvider;
    }
}
