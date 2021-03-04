<?php


namespace backend\models;


use common\models\TaskStatus as CommonTaskStatus;

class TaskStatus extends CommonTaskStatus
{
    public function delete()
    {
        if ($this->deletedAt == null)
            $this->deletedAt = time();
        return $this->save();
    }
}