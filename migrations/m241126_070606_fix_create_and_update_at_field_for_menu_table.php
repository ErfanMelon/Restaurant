<?php

use yii\db\Migration;

/**
 * Class m241126_070606_fix_create_and_update_at_field_for_menu_table
 */
class m241126_070606_fix_create_and_update_at_field_for_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('menu','created_at',$this->integer()->null());
        $this->alterColumn('menu','updated_at',$this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('menu','created_at',$this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'));
        $this->alterColumn('menu','updated_at',$this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241126_070606_fix_create_and_update_at_field_for_menu_table cannot be reverted.\n";

        return false;
    }
    */
}
