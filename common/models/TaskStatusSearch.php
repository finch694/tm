<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * TaskStatusSearch represents the model behind the search form of `common\models\TaskStatus`.
 */
class TaskStatusSearch extends TaskStatus
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['text', 'color','deletedAt'], 'safe'],
            [['finally'], 'boolean'],
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
        $query = TaskStatus::find();

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
            'finally' => $this->finally,
//            'deletedAt' => $this->deletedAt,
        ]);

        $query->andFilterWhere(['ilike', 'text', $this->text])
            ->andFilterWhere(['ilike', 'color', $this->color]);
        if ($this->deletedAt){
            $query->andFilterWhere([ $this->deletedAt,'deletedAt',new Expression('null')]);
        }

        return $dataProvider;
    }
}
