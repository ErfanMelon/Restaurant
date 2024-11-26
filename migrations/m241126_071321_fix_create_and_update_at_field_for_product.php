<?php

use yii\db\Migration;

/**
 * Class m241126_071321_fix_create_and_update_at_field_for_product
 */
class m241126_071321_fix_create_and_update_at_field_for_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('product','created_at',$this->integer()->null());
        $this->alterColumn('product','updated_at',$this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('product','created_at',$this->timestamp()->null());
        $this->alterColumn('product','updated_at',$this->timestamp()->null());
    }
}
