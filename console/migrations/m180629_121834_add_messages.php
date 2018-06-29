<?php

use yii\db\Migration;

/**
 * Class m180629_121834_add_messages
 */
class m180629_121834_add_messages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('message', ['id', 'from', 'to', 'text', 'created_at'],
            [
                [1, 1, 2, 'Привет, Петя! Как дела?', time()],
                [2, 2, 1, 'Привет, Маша! Норм, как твои?', time()],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('message', ['id' => [1, 2]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180629_121834_add_messages cannot be reverted.\n";

        return false;
    }
    */
}
