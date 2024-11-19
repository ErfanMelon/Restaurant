<?php

use yii\db\Migration;

/**
 * Class m241119_100153_add_order_table
 */
class m241119_100153_add_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order',[
            'order_id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'total_price' => $this->integer()->notNull(),
            'order_date'=>$this->integer()->notNull(),
            'order_status_id'=>$this->integer()->notNull(),
            'description'=>$this->string(350)->null()
        ]);
        $this->addForeignKey('fk_user_order','order','user_id','user','user_id');

        $this->createTable('order_status',[
            'order_status_id' => $this->primaryKey(),
            'name' =>$this->string(20)->notNull(),
        ]);

        $this->addForeignKey('fk_order_order_status','order','order_status_id','order_status','order_status_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order_status');
        $this->dropTable('order');
    }
}
