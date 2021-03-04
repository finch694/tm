<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_priority}}`.
 */
class m210303_193218_create_task_priority_table extends Migration
{
    private $tableName = '{{%task_priority}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name'=> $this->string()->notNull(),
            'value'=>$this->integer()->defaultValue(0),
            'active'=>$this->boolean()->defaultValue(true)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
