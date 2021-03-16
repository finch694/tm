<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[AttachmentFiles]].
 *
 * @see AttachmentFiles
 */
class AttachmentFilesQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AttachmentFiles[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AttachmentFiles|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
