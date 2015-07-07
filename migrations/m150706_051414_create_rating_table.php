<?php

use yii\db\Schema;
use yii\db\Migration;

class m150706_051414_create_rating_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%rating}}', [
            'id'                   => Schema::TYPE_PK,
            'user_id'              => Schema::TYPE_INTEGER . ' NOT NULL',
            'sender_id'              => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at'           => Schema::TYPE_INTEGER . ' NOT NULL',
            'rate'                 => Schema::TYPE_FLOAT,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createIndex('rating_user_id', '{{%rating}}', 'user_id', false);
        $this->createIndex('rating_sender_id', '{{%rating}}', 'sender_id', false);

        $this->addForeignKey('fk_user_rating', '{{%rating}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_sender_rating', '{{%rating}}', 'sender_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        echo "m150706_051414_create_rating_table cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
