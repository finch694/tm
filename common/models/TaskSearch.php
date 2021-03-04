<?php

namespace common\models;

use DateTime;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TaskSearch represents the model behind the search form of `common\models\Task`.
 */
class TaskSearch extends Task
{
    public $userName;

    public $managerName;

    public $creatorName;

    public $taskStatus;

    public $taskPriority;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'user_id', 'manager_id', 'creator_id', 'deletedAt', 'priority_id'], 'integer'],
            [['title', 'text', 'files', 'userName', 'managerName', 'creatorName', 'taskStatus', 'taskPriority', 'createdAt', 'updatedAt'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge( parent::attributes(),['managerName'=>'Manager', 'creatorName'=>'Creator']);
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
//        var_dump($params);exit();
        $query = Task::find()
            ->joinWith('user')
            ->joinWith('status')
            ->joinWith('priority')
            ->joinWith('creator')
            ->joinWith('manager');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['userName'] = [
            'asc' => ['u.username' => SORT_ASC],
            'desc' => ['u.username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['managerName'] = [
            'asc' => ['um.username' => SORT_ASC],
            'desc' => ['um.username' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['creatorName'] = [
            'asc' => ['uc.username' => SORT_ASC],
            'desc' => ['uc.username' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['taskStatus'] = [
            'asc' => ['task_status.text' => SORT_ASC],
            'desc' => ['task_status.text' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['taskPriority'] = [
            'asc' => ['task_priority.name' => SORT_ASC],
            'desc' => ['task_priority.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'task.id' => $this->id,
            'status_id' => $this->status_id,
            'user_id' => $this->user_id,
            'manager_id' => $this->manager_id,
            'creator_id' => $this->creator_id,
//            'createdAt' => $this->createdAt,
//            'updatedAt' => $this->updatedAt,
//            'deletedAt' => $this->deletedAt,
            'priority_id' => $this->priority_id,
        ]);

        $query->andFilterWhere(['ilike', 'task.title', $this->title])
            ->andFilterWhere(['ilike', 'task.text', $this->text])
            ->andFilterWhere(['ilike', 'u.username', $this->userName])
            ->andFilterWhere(['ilike', 'uc.username', $this->creatorName])
            ->andFilterWhere(['ilike', 'um.username', $this->managerName])
            ->andFilterWhere(['task_status.id' => $this->taskStatus])
            ->andFilterWhere(['task_priority.id' => $this->taskPriority])
            ->andFilterWhere(['ilike', 'files', $this->files]);
        if ($this->createdAt) {
            $date = new DateTime($this->createdAt);
            $start = $date->getTimestamp();
            $query->andFilterWhere(['between', 'task.createdAt', $start, $start + 86400]);
        }
        if ($this->updatedAt) {
            $date = new DateTime($this->updatedAt);
            $start = $date->getTimestamp();
            $query->andFilterWhere(['between', 'task.updatedAt', $start, $start + 86400]);
        }

        return $dataProvider;
    }
}
