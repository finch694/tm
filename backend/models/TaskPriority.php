<?php


namespace backend\models;


use common\models\TaskPriority as CommonTaskPriority;

class TaskPriority extends CommonTaskPriority
{
    public function changeActive()
    {

            $this->active = !$this->active;
        return $this->save();
    }
}