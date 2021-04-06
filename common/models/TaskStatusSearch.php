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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'finally' => $this->finally,
        ]);

        $query->andFilterWhere(['ilike', 'text', $this->text])
            ->andFilterWhere(['ilike', 'color', $this->color]);
        if ($this->deletedAt==='active'){
            $query->andFilterWhere([ 'is','deletedAt',new Expression('null')]);
        }
        if ($this->deletedAt==='deleted'){
            $query->andFilterWhere([ 'is not','deletedAt',new Expression('null')]);
        }

        return $dataProvider;
    }
}
