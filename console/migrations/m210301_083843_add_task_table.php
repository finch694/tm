<?php

use yii\db\Migration;

/**
 * Class m210301_083843_add_task_table
 */
class m210301_083843_add_task_table extends Migration
{
    private $tableName = '{{%task}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
            'files' => $this->json()->defaultValue(null),
            'status_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'manager_id'=>$this->integer()->notNull(),
            'creator_id'=>$this->integer()->notNull(),
            'createdAt'=>$this->integer()->notNull()->defaultExpression(" extract(epoch from now())"),
            'updatedAt'=>$this->integer()->notNull()->defaultExpression(" extract(epoch from now())"),
            'deletedAt'=>$this->integer()->defaultValue(null)

        ]);
        $this->addForeignKey(
            'status_id',
            $this->tableName,
            'status_id',
            'task_status',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'user_id',
            $this->tableName,
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'manager_id',
            $this->tableName,
            'manager_id',
            'user',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'creator_id',
            $this->tableName,
            'creator_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('status_id',$this->tableName);
        $this->dropForeignKey('user_id',$this->tableName);
        $this->dropForeignKey('manager_id',$this->tableName);
        $this->dropForeignKey('creator_id',$this->tableName);
        $this->dropTable($this->tableName);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210301_083843_add_task_table cannot be reverted.\n";

        return false;
    }
    */
}
