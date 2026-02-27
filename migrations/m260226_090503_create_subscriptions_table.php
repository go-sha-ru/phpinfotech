<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriptions}}`.
 */
class m260226_090503_create_subscriptions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriptions}}', [
            'id' => $this->primaryKey(),
            'phone' => $this->string()->notNull(),
            'author_id' => $this->integer()
        ]);

        $this->createIndex(
            'idx-subscriptions-author_id',
            'subscriptions',
            'author_id'
        );

        $this->addForeignKey(
            'fk-subscriptions-author_id',
            'subscriptions',
            'author_id',
            'author',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscriptions}}');
    }
}
