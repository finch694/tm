<?php


namespace common\widgets\tasksList;


use common\models\Task;
use Yii;
use yii\base\Widget;

class TasksList extends Widget
{
    public function run()
    {
        $taskList = Task::find()
            ->select(['task.id','title', 'status_id', 'priority_id'])
            ->joinWith('status')
            ->joinWith('priority')
            ->andWhere(['task.deletedAt' => null])
            ->andWhere(['user_id' => Yii::$app->user->getId()])
            ->andWhere(['task_status.finally'=>false])
            ->orderBy('task_priority.value')
            ->asArray()->all();
        return $this->render('tasks-list',[
            'taskList'=>$taskList
        ]);
    }
}