<?php

namespace backend\models;

use DateTime;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LogSearch represents the model behind the search form of `backend\models\Log`.
 */
class LogSearch extends Log
{
    public $username;
    public $ip;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'level'], 'integer'],
            [['category', 'username', 'ip', 'prefix', 'message', 'log_time'], 'safe'],
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
        $query = static::find()
            ->andWhere(['category' => 'log'])
            ->leftJoin('user', "(log.prefix::jsonb)->>'userId'=(\"user\".id::text)");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC]
        ];

        $dataProvider->sort->defaultOrder = ['log_time' => SORT_DESC];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'level' => $this->level,
        ]);

        $query->andFilterWhere(['ilike', 'category', $this->category])
            ->andFilterWhere(['ilike', 'prefix', $this->prefix])
            ->andFilterWhere(['ilike', 'message', $this->message])
            ->andFilterWhere(['ilike', 'user.username', $this->username])
            ->andFilterWhere(['ilike', "(log.prefix::jsonb)->>'ip'", $this->ip]);

        if ($this->log_time) {
            $date = new DateTime($this->log_time);
            $start = $date->getTimestamp();
            $query->andFilterWhere(['between', 'log_time', $start, $start + 86400]);
        }

        $dataProvider->prepare();
        return $dataProvider;
    }
}
