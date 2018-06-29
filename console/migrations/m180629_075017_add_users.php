<?php

use yii\db\Migration;

/**
 * Class m180629_075017_add_users
 */
class m180629_075017_add_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('user', [
            'id',
            'username',
            'email',
            'auth_key',
            'password_hash',
            'created_at',
            'updated_at',
        ],
            [
                [
                    1,
                    'Маша Петрова',
                    'mary@example.com',
                    Yii::$app->getSecurity()->generateRandomString(),
                    Yii::$app->getSecurity()->generatePasswordHash('123456'),
                    time(),
                    time(),
                ],
                [
                    2,
                    'Петя Иванов',
                    'pete@example.com',
                    Yii::$app->getSecurity()->generateRandomString(),
                    Yii::$app->getSecurity()->generatePasswordHash('123456'),
                    time(),
                    time(),
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', ['id' => [1, 2]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180629_075017_add_users cannot be reverted.\n";

        return false;
    }
    */
}
