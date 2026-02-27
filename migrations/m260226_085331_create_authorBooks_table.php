<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%authorBooks}}`.
 */
class m260226_085331_create_authorBooks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%authorBooks}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'book_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-authorBooks-author_id',
            'authorBooks',
            'author_id'
        );

        $this->addForeignKey(
            'fk-authorBooks-author_id',
            'authorBooks',
            'author_id',
            'author',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-authorBooks-book_id',
            'authorBooks',
            'book_id'
        );

        $this->addForeignKey(
            'fk-authorBooks-book_id',
            'authorBooks',
            'book_id',
            'books',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-authorBooks-author_id',
            'authorBooks'
        );

        $this->dropIndex(
            'idx-authorBooks-author_id',
            'authorBooks'
        );

        $this->dropForeignKey(
            'fk-authorBooks-book_id',
            'authorBooks'
        );

        $this->dropIndex(
            'idx-authorBooks-book_id',
            'authorBooks'
        );

        $this->dropTable('{{%authorBooks}}');
    }
}
