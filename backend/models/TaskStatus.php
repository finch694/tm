<?php

namespace app\models;

use Yii;
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
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['status_id' => 'id']);
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
