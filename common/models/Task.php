<?php

namespace common\models;

use backend\models\UserQuery;
use yii\behaviors\TimestampBehavior;
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
            [['title', 'status_id', 'manager_id', 'creator_id', 'priority_id'], 'required'],
            [['text'], 'string'],
            [['files', 'createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['status_id', 'user_id', 'manager_id', 'creator_id', 'priority_id'], 'integer'],
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

    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            ['class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createdAt', 'updatedAt'], // useless?
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updatedAt'],
                ],
            ]]);
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
        return $this->hasOne(User::class, ['id' => 'user_id'])->from(['u' => User::tableName()]);
    }

    /**
     * Gets query for [[Manager]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getManager()
    {
        return $this->hasOne(User::class, ['id' => 'manager_id'])->from(['um' => User::tableName()]);
    }

    /**
     * Gets query for [[Creator]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id'])->from(['uc' => User::tableName()]);
    }

    /**
     * {@inheritdoc}
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
//        var_dump($this->text);exit();
        return parent::beforeSave($insert);
    }
}
/*
 * Lorem Ipsum is simply dummy text of the https://www.lipsum.com/ printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.http://backend.test/task/index
 */