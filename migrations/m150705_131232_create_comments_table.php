<?php

use yii\db\Schema;
use yii\db\Migration;

class m150705_131232_create_comments_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%comments}}', [
            'id'                   => Schema::TYPE_PK,
            'user_id'              => Schema::TYPE_INTEGER . ' NOT NULL',
            'sender_id'              => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at'           => Schema::TYPE_INTEGER . ' NOT NULL',
            'text'                 => Schema::TYPE_TEXT,
            'deleted'              => Schema::TYPE_BOOLEAN . ' DEFAULT 0',
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createIndex('comments_user_id', '{{%comments}}', 'user_id', false);
        $this->createIndex('comments_from_id', '{{%comments}}', 'sender_id', false);

        $this->addForeignKey('fk_user_comment', '{{%comments}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_sender_comment', '{{%comments}}', 'sender_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        echo "m150705_131232_create_comments_table cannot be reverted.\n";
        $this->dropTable('{{%comments}}');
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
