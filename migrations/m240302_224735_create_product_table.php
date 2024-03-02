<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m240302_224735_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'price' => $this->decimal(10,2)->notNull(),
            'id_customer' => $this->integer()->notNull(),
            'photo' => $this->string(),
        ]);

        $this->createIndex(
            '{{%idx-product-id_customer}}',
            '{{%product}}',
            'id_customer'
        );

        $this->addForeignKey(
            '{{%fk-product-id_customer}}',
            '{{%product}}',
            'id_customer',
            '{{%customer}}',
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
            '{{%fk-product-id_customer}}',
            '{{%product}}'
        );

        $this->dropIndex(
            '{{%idx-product-id_customer}}',
            '{{%product}}'
        );

        $this->dropTable('{{%product}}');
    }
}
