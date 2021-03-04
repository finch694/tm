<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[TaskPriority]].
 *
 * @see TaskPriority
 */
class TaskPriorityQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaskPriority[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaskPriority|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
