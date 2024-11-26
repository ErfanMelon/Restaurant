<?php

use yii\db\Migration;

/**
 * Class m241126_065842_fix_create_and_update_at_field_for_product_table
 */
class m241126_065842_fix_create_and_update_at_field_for_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('restaurant','created_at',$this->integer()->null());
        $this->alterColumn('restaurant','updated_at',$this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('restaurant','created_at',$this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'));
        $this->alterColumn('restaurant','updated_at',$this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'));
    }
}
