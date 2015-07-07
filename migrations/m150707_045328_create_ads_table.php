<?php

use yii\db\Schema;
use yii\db\Migration;

class m150707_045328_create_ads_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%ads}}', [
            'id'                   => Schema::TYPE_PK,
            'user_id'              => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at'           => Schema::TYPE_INTEGER . ' NOT NULL',
            'body'                 => Schema::TYPE_TEXT . ' NOT NULL',
            'deleted'              => Schema::TYPE_BOOLEAN . ' DEFAULT 0',
            'photo'                => Schema::TYPE_STRING,
            'subject'              => Schema::TYPE_STRING . ' NOT NULL',
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createIndex('ads_user_id', '{{%ads}}', 'user_id', false);

        $this->addForeignKey('fk_user_ads', '{{%ads}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        echo "m150705_131232_create_comments_table cannot be reverted.\n";
    }

    public function down()
    {
        echo "m150707_045328_create_ads_table Table ads is created.\n";

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
