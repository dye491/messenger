<?php

use yii\db\Migration;

/**
 * Class m180702_093958_alter_message_table_add_new
 */
class m180702_093958_alter_message_table_add_new extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('message', 'new', $this->boolean()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('message', 'new');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180702_093958_alter_message_table_add_new cannot be reverted.\n";

        return false;
    }
    */
}
