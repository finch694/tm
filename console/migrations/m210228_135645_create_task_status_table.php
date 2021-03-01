<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_status}}`.
 */
class m210228_135645_create_task_status_table extends Migration
{
    private $tableName ='{{%task_status}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'text'=>$this->string()->notNull(),
            'color'=>$this->string()->notNull()->defaultValue('#AFB1B3'),
            'finally'=>$this->boolean()->notNull()->defaultValue(false)
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
