<?php

use yii\db\Migration;

/**
 * Class m210305_120452_mod_column_user_id_in_task_table
 */
class m210305_120452_mod_column_user_id_in_task_table extends Migration
{
    private $tableName = '{{%task}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn($this->tableName, 'user_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn($this->tableName,'user_id',$this->integer()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210305_120452_mod_column_user_id_in_task_table cannot be reverted.\n";

        return false;
    }
    */
}
