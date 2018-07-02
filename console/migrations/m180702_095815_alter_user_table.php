<?php

use yii\db\Migration;

/**
 * Class m180702_095815_alter_user_table
 */
class m180702_095815_alter_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'about', $this->string());
        $this->addColumn('user', 'online', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'about');
        $this->dropColumn('user', 'online');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180702_095815_alter_user_table cannot be reverted.\n";

        return false;
    }
    */
}
