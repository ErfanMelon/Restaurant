<?php

use yii\db\Migration;

/**
 * Class m241117_101727_createRestaurant
 */
class m241117_101727_createRestaurant extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%restaurant}}', [
            'restaurant_id' => $this->primaryKey(),
            'name' => $this->string(350)->notNull(),
            'address' => $this->string(350)->notNull(),
            'phone_number' => $this->string(11)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()->defaultExpression('unix_timestamp()'),
            'updated_at' => $this->integer()->null(),
        ]);
        $this->addForeignKey('FK_restaurant_user', 'restaurant', 'user_id', 'user', 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%restaurant}}');
    }
}
