<?php

use yii\db\Migration;

/**
 * Handles the creation of table `contact`.
 */
class m180702_142507_create_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('contact', [
            'user_id' => $this->integer(),
            'contact_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('pk_user_contact', 'contact', ['user_id', 'contact_id']);
        $this->addForeignKey('fk_contact_user_id_user_id', 'contact', 'user_id', 'user', 'id');
        $this->addForeignKey('fk_contact_contact_id_user_id', 'contact', 'contact_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('contact');
    }
}
