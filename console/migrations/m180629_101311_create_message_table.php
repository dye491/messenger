<?php

use yii\db\Migration;

/**
 * Handles the creation of table `message`.
 */
class m180629_101311_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('message', [
            'id' => $this->primaryKey(),
            'from' => $this->integer(),
            'to' => $this->integer(),
            'text' => $this->text(),
            'created_at' => $this->integer(),
        ]);

        $this->addForeignKey('fk_message_from_user_id', 'message', 'from', 'user', 'id');
        $this->addForeignKey('fk_message_to_user_id', 'message', 'to', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('message');
    }
}
