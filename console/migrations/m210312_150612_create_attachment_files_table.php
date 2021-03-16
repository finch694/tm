<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attachment_files}}`.
 */
class m210312_150612_create_attachment_files_table extends Migration
{
    private $tableName = '{{%attachment_files}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'task_id'=>$this->integer()->notNull(),
            'name'=>$this->text()->notNull(),
            'native_name'=>$this->text()->notNull(),
            'createdAt'=>$this->integer()->notNull()->defaultExpression(" extract(epoch from now())"),
        ]);
        $this->addForeignKey(
            'task_id',
            $this->tableName,
            'task_id',
            'task',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('task_id',$this->tableName);
        $this->dropTable($this->tableName);
    }
}
