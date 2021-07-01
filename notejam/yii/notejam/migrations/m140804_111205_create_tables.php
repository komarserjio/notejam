<?php

use yii\db\Schema;
use yii\db\Migration;

class m140804_111205_create_tables extends Migration
{
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
        ]);
        $this->createTable('pads', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);
        $this->createTable('notes', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'pad_id' => $this->integer(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('notes');
        $this->dropTable('pads');
        $this->dropTable('users');
    }
}
