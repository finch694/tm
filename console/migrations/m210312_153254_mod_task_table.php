<?php

use yii\db\Migration;

/**
 * Class m210312_153254_mod_task_table
 */
class m210312_153254_mod_task_table extends Migration
{
    private $tableName = '{{%task}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableName,'files');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn($this->tableName,'files',$this->json()->defaultValue(null));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }
            'files' => $this->json()->defaultValue(null),

    public function down()
    {
        echo "m210312_153254_mod_task_table cannot be reverted.\n";

        return false;
    }
    */
}
