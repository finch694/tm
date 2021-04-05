<?php


namespace common\widgets\tasksSummary;


use common\models\Task;
use yii\base\Widget;

class TasksSummary extends Widget
{
    public function run()
    {

        $tasksSummary = Task::find()
            ->select(['status_id', 'count(task.id)'])
            ->joinWith('status')
            ->andWhere(['task_status.deletedAt' => null])
            ->andWhere(['task.deletedAt' => null])
            ->groupBy('task.status_id')
            ->asArray()
            ->all();
        $totalCount = Task::find()
            ->joinWith('status')
            ->andWhere(['task_status.deletedAt' => null])
            ->andWhere(['task.deletedAt' => null])
            ->count();

        return $this->render('tasks-summary', [
            'tasksSummary' => $tasksSummary,
            'totalCount' => $totalCount
        ]);
    }
}