<?php


namespace backend\models;
use \common\models\Task as CommonTask;

class Task extends CommonTask
{

    /**
     * soft delete task
     */
    public function softDelete()
    {
        if (!$this->deletedAt) {
            $this->deletedAt = time();
            $this->save();
        }
    }
    /**
     *  recover task
     */
    public function recover()
    {
        if ($this->deletedAt) {
            $this->deletedAt = null;
            $this->save();
        }
    }
}