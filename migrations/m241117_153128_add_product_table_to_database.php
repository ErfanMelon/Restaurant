<?php

use yii\db\Migration;

/**
 * Class m241117_153128_add_product_table_to_database
 */
class m241117_153128_add_product_table_to_database extends Migration
{
    public function safeUp()
    {
        $this->createTable('product', [
            'product_id' => $this->primaryKey(),
            'menu_id' => $this->integer()->notNull(),
            'name' => $this->string(100)->notNull(),
            'inStock' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_by' => $this->integer()->notNull(),
            'updated_at' => $this->timestamp()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
        $this->addForeignKey('fk_product_menu', 'product', 'menu_id', 'menu', 'menu_id');
        $this->addForeignKey('fk_creatorUser_menu', 'product', 'created_by', 'user', 'user_id');
        $this->addForeignKey('fk_modifierUser_menu', 'product', 'updated_by', 'user', 'user_id');
        $this->createIndex('product_name', 'product', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product');
    }

}
