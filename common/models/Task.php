<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property string|null $text
 * @property string|null $files
 * @property int $status_id
 * @property int $user_id
 * @property int $manager_id
 * @property int $creator_id
 * @property int $createdAt
 * @property int $updatedAt
 * @property int|null $deletedAt
 * @property int $priority_id
 *
 * @property TaskPriority $priority
 * @property TaskStatus $status
 * @property User $user
 * @property User $manager
 * @property User $creator
 */
class Task extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'status_id', 'user_id', 'manager_id', 'creator_id', 'priority_id'], 'required'],
            [['text'], 'string'],
            [['files'], 'safe'],
            [['status_id', 'user_id', 'manager_id', 'creator_id', 'createdAt', 'updatedAt', 'deletedAt', 'priority_id'], 'integer'],
            [['deletedAt'], 'default', 'value' => null],
            [['createdAt'], 'default', 'value' => time()],
            [['updatedAt'], 'default', 'value' => time()],
            [['title'], 'string', 'max' => 255],
            [['priority_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskPriority::class, 'targetAttribute' => ['priority_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatus::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['manager_id' => 'id']],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['creator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'files' => 'Files',
            'status_id' => 'Status ID',
            'user_id' => 'User ID',
            'manager_id' => 'Manager ID',
            'creator_id' => 'Creator ID',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'deletedAt' => 'Deleted At',
            'priority_id' => 'Priority ID',
        ];
    }

    /**
     * Gets query for [[Priority]].
     *
     * @return \yii\db\ActiveQuery|TaskPriorityQuery
     */
    public function getPriority()
    {
        return $this->hasOne(TaskPriority::class, ['id' => 'priority_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery|TaskStatusQuery
     */
    public function getStatus()
    {
        return $this->hasOne(TaskStatus::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->from(['u'=>User::tableName()]);
    }

    /**
     * Gets query for [[Manager]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getManager()
    {
        return $this->hasOne(User::class, ['id' => 'manager_id'])->from(['um'=>User::tableName()]);
    }

    /**
     * Gets query for [[Creator]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id'])->from(['uc'=>User::tableName()]);
    }

    /**
     * {@inheritdoc}
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }
}
