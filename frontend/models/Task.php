<?php


namespace frontend\models;
use \common\models\Task as CommonTask;

class Task extends CommonTask
{
    public function rules()
    {
        return array_merge(parent::rules(),[
            [['page'], 'safe'],
        ]);
    }
}