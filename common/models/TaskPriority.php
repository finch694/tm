<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "task_priority".
 *
 * @property int $id
 * @property string $name
 * @property int|null $value
 * @property bool $active
 *
 * @property Task[] $tasks
 */
class TaskPriority extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_priority';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['value'], 'default', 'value' => null],
            [['value'], 'integer'],
            [['active'], 'boolean'],
            [['active'], 'default','value' => true],
            [['name'], 'string', 'max' => 255],
            [['name'],'filter','filter' => '\yii\helpers\HtmlPurifier::process']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'active' => 'Active',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['priority_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TaskPriorityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskPriorityQuery(get_called_class());
    }
}
