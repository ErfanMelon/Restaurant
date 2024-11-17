<?php

use yii\db\Migration;

/**
 * Class m241117_100627_createuser
 */
class m241117_100627_createuser extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}',[
            'user_id'=> $this->primaryKey(),
            'user_name'=> $this->string(150)->notNull(),
            'email'=> $this->string(150)->notNull(),
            'password'=> $this->string(255)->notNull(),
            'auth_key'=> $this->string(255)->notNull(),
            'access_token'=> $this->string(255)->notNull(),
            'user_status'=>"enum ('ACTIVE', 'DEACTIVE') default 'ACTIVE' not null",
            'user_type' =>"enum ('ADMIN', 'USER', 'RESTAURANT') default 'USER' not null"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
