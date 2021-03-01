<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[TaskStatus]].
 *
 * @see TaskStatus
 */
class TaskStatusQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaskStatus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaskStatus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
