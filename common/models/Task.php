<?php

namespace common\models;

use backend\models\UserQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property string|null $text
 * @property int $status_id
 * @property int $user_id
 * @property int $manager_id
 * @property int $creator_id
 * @property int $createdAt
 * @property int $updatedAt
 * @property int|null $deletedAt
 * @property int $priority_id
 *
 * @property AttachmentFiles[] $attachmentFiles
 * @property TaskPriority $priority
 * @property TaskStatus $status
 * @property User $user
 * @property User $manager
 * @property User $creator
 */
class Task extends ActiveRecord
{
    public $files;

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
            [['createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['status_id', 'user_id', 'manager_id', 'creator_id', 'priority_id'], 'integer'],
            [['deletedAt'], 'default', 'value' => null],
            [['createdAt'], 'default', 'value' => time()],
            [['updatedAt'], 'default', 'value' => time()],
            [['title'], 'string', 'max' => 255],
            [['files'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 0],
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
        return array_merge(parent::behaviors(), [
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

    /**
     * Gets query for [[Creator]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id'])->from(['uc' => User::tableName()]);
    }

    public function getAttachmentFiles()
    {
        return $this->hasMany(AttachmentFiles::class, ['task_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }

    public function upload()
    {

        if ($this->tfiles) {
            $names = json_decode($this->files);
            if ($this->validate()) {
                foreach ($this->tfiles as $file) {
                    $names[] = Yii::$app->storage->getFile(Yii::$app->storage->saveUploadedFile($file));
                }
            }
            $this->files = json_encode($names);

            $this->tfiles = null;
        }
        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

    }
}