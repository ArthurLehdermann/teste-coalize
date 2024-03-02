<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer}}`.
 */
class m240301_231100_create_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'cpf' => $this->string(11)->notNull()->unique(),
            'cep' => $this->string(8),
            'street' => $this->string(),
            'number' => $this->string(),
            'city' => $this->string(),
            'state' => $this->string(),
            'complement' => $this->string(),
            'photo' => $this->string(),
        ]);

        $this->addColumn('{{%customer}}', 'gender', "ENUM('male', 'female', 'undefined') NOT NULL DEFAULT 'undefined'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer}}');
    }
}