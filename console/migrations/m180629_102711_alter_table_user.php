<?php

use yii\db\Migration;

/**
 * Class m180629_102711_alter_table_user
 */
class m180629_102711_alter_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user','username', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('user','username', $this->string()->notNull()->unique());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180629_102711_alter_table_user cannot be reverted.\n";

        return false;
    }
    */
}
