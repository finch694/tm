<?php


namespace common\widgets\tasksSummary;


use common\models\Task;
use common\models\TaskStatus;
use yii\base\Widget;

class TasksSummary extends Widget
{
    public function run()
    {

        $tasksSummary = TaskStatus::find()
            ->select(['task_status.id', 'task_status.text', 'task_status.color', 'count(task_status.id)'])
            ->joinWith('tasks')
            ->andWhere(['task_status.deletedAt' => null])
            ->andWhere(['task.deletedAt' => null])
            ->groupBy('task_status.id')
            ->orderBy(['task_status.finally' => SORT_DESC])
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