<?php

use yii\db\Schema;
use yii\db\Migration;

class m150706_071824_add_user_column_rate extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'rate', 'decimal(2,1) DEFAULT 0.0');
        echo "m150706_071824_add_user_column_rate column 'rate' added into user table.\n";
    }

    public function down()
    {
        echo "m150706_071824_add_user_column_rate cannot be reverted.\n";

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
