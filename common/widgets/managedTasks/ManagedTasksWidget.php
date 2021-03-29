<?php

namespace common\widgets\managedTasks;

use common\models\TaskSearch;
use Yii;
use yii\base\Widget;

class ManagedTasksWidget extends Widget
{
    public const MT_ACTIVE = false;
    public const MT_CLOSED = true;

    /**
     * @var bool
     */
    public $mode = self::MT_ACTIVE;

    public function run()
    {
        $taskList = TaskSearch::find()
            ->select(['task.id', 'title', 'status_id', 'priority_id', 'task.user_id'])
            ->joinWith('status')
            ->joinWith('priority')
            ->joinWith('user')
            ->andWhere(['task.deletedAt' => null])
            ->andWhere(['manager_id' => Yii::$app->user->getId()])
            ->andWhere(['task_status.finally' => $this->mode])
            ->orderBy('task_priority.value')
            ->all();

        return $this->render('managed-tasks', [
            'taskList' => $taskList,
            'closed' => $this->mode,
        ]);
    }
}