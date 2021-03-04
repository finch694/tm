<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TaskPrioritySearch represents the model behind the search form of `common\models\TaskPriority`.
 */
class TaskPrioritySearch extends TaskPriority
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'value'], 'integer'],
            [['name'], 'safe'],
            [['active'], 'boolean'],
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
        $query = TaskPriority::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'value' => $this->value,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name]);

        return $dataProvider;
    }
}
