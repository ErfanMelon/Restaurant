<?php

use yii\db\Migration;

/**
 * Class m241119_101244_add_order_item_table
 */
class m241119_101244_add_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order_item', [
            'order_item_id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'unit_price' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull()
        ]);
        $this->addForeignKey('fk__order_order_item','order_item','order_id','order','order_id');
        $this->addForeignKey('fk__product_order_item','order_item','product_id','product','product_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order_item');
    }
}
