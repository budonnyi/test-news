<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news_to_category}}`.
 */
class m210212_064807_create_news_to_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news_to_category}}', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer(3),
            'category_id' => $this->integer(3),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news_to_category}}');
    }
}
