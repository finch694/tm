<?php

use yii\db\Migration;

/**
 * Class m210303_114400_add_column_deletedAt_to_task_status
 */
class m210303_114400_add_column_deletedAt_to_task_status extends Migration
{
    private $tableName ='{{%task_status}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName,'deletedAt',$this->integer()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName,'deletedAt');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210303_114400_add_column_deletedAt_to_task_status cannot be reverted.\n";

        return false;
    }
    */
}
