<?php

use yii\db\Migration;

/**
 * Class m241118_200020_add_price_to_product
 */
class m241118_200020_add_price_to_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'price', $this->integer()->notNull());
        $this->dropTable('price');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('product', 'price');
        $this->createTable('{{%price}}',[
            'price_id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'value' => $this->integer()->notNull(),
            'from_date' => $this->integer()->notNull(),
            'to_date' => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
        $this->addForeignKey('fk_price_product','{{%price}}','product_id','{{%product}}','product_id');
        $this->addForeignKey('fk_price_creator','{{%price}}','created_by','{{%user}}','user_id');
        $this->addForeignKey('fk_price_modifiedby','{{%price}}','updated_by','{{%user}}','user_id');
        $this->createIndex('idx_price_product','{{%price}}','product_id');
    }
}
