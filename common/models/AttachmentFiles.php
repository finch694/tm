<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "attachment_files".
 *
 * @property int $id
 * @property int $task_id
 * @property string $name
 * @property string $native_name
 * @property int $createdAt
 *
 * @property Task $task
 */
class AttachmentFiles extends ActiveRecord
{

    public static function tableName()
    {
        return 'attachment_files';
    }

    public function rules()
    {
        return [
            [['task_id', 'name', 'native_name'], 'required'],
            [['task_id'], 'integer'],
            [['task_id'], 'exist', 'skipOnError' => false, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
            [['name', 'native_name'], 'string'],
            [['createdAt'], 'safe'],
            [['createdAt'], 'default', 'value' => time()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'task_id' => 'Task',
            'native_name' => 'Name',
            'name' => 'new name',
            'createdAt' => ' Created at'
        ];
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            ['class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createdAt'],
                ],
            ]
        ]);
    }

    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    public static function find()
    {
        return new AttachmentFilesQuery(get_called_class());
    }
}