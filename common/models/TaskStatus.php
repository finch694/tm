<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "task_status".
 *
 * @property int $id
 * @property string $text
 * @property string $color
 * @property bool $finally
 *
 * @property Task[] $tasks
 * @property int|null $deletedAt
 */
class TaskStatus extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['finally'], 'boolean'],
            [['text', 'color'], 'string', 'max' => 255],
            [['deletedAt'], 'safe'],
            [['deletedAt'], 'default', 'value' => null],
            [['text'],'filter','filter' => '\yii\helpers\HtmlPurifier::process']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'color' => 'Color',
            'finally' => 'Finally',
            'deletedAt' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['status_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TaskStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskStatusQuery(get_called_class());
    }
}
