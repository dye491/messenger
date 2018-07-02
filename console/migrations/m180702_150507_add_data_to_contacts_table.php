<?php

use yii\db\Migration;

/**
 * Class m180702_150507_add_data_to_contacts_table
 */
class m180702_150507_add_data_to_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('contact', [
            'user_id' => 1,
            'contact_id' => 2,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('contact', [
            'user_id' => 1,
            'contact_id' => 2,
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180702_150507_add_data_to_contacts_table cannot be reverted.\n";

        return false;
    }
    */
}
