<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property int|null $level
 * @property string|null $category
 * @property float|null $log_time
 * @property string|null $prefix
 * @property string|null $message
 * @property array|null $info
 */
class Log extends ActiveRecord
{
    public $info;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level'], 'default', 'value' => null],
            [['level'], 'integer'],
            [['log_time'], 'number'],
            [['prefix', 'message'], 'string'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'category' => 'Category',
            'log_time' => 'Time',
            'prefix' => 'Prefix',
            'message' => 'Message',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->info = json_decode($this->prefix);
    }
}
