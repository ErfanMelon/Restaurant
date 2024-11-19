<?php

use yii\db\Migration;

/**
 * Class m241119_122211_seed_order_status_table
 */
class m241119_122211_seed_order_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('order_status',['name'=>'cancelled']);
        $this->insert('order_status',['name'=>'preInvoice']);
        $this->insert('order_status',['name'=>'restaurantVerification']);
        $this->insert('order_status',['name'=>'pendingPreparation']);
        $this->insert('order_status',['name'=>'send']);
        $this->insert('order_status',['name'=>'delivered']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('order_status');
    }
}
