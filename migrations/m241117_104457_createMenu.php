<?php

use yii\db\Migration;

/**
 * Class m241117_104457_createMenu
 */
class m241117_104457_createMenu extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu}}', [
            'menu_id' =>$this->primaryKey(),
            'restaurant_id' => $this->integer()->notNull(),
            'title' =>$this->string(150)->notNull(),
            'is_active'=>$this->boolean()->notNull()->defaultValue(1),
            'created_at'=>$this->integer()->notNull()->defaultExpression('unix_timestamp()'),
            'updated_at'=>$this->integer()->null(),
            'created_by'=>$this->integer()->notNull(),
            'updated_by'=>$this->integer()->null(),
        ]);
        $this->addForeignKey('fk_menu_restaurant', 'menu', 'restaurant_id', 'restaurant', 'restaurant_id');
        $this->addForeignKey('fk_menu_created_by', 'menu', 'created_by', 'user', 'user_id');
        $this->addForeignKey('fk_menu_updated_by', 'menu', 'updated_by', 'user', 'user_id');
        $this->createIndex('restaurant_id', 'menu', 'restaurant_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%menu}}');
    }
}
