<?php

use yii\db\Migration;

/**
 * Class m210303_195840_add_foreign_key_priority_id_to_task_table
 */
class m210303_195840_add_foreign_key_priority_id_to_task_table extends Migration
{
    private $tableName = '{{%task}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName,'priority_id',$this->integer()->notNull());

        $this->addForeignKey(
            'priority_id',
            $this->tableName,
            'priority_id',
            'task_priority',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('priority_id',$this->tableName);
        $this->dropColumn($this->tableName,'priority_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210303_195840_add_foreign_key_priority_id_to_task_table cannot be reverted.\n";

        return false;
    }
    */
}
