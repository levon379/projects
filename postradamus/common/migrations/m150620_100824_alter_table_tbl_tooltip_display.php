<?php

use yii\db\Schema;
use yii\db\Migration;

class m150620_100824_alter_table_tbl_tooltip_display extends Migration
{
    public function up()
    {
		$this->execute( 'ALTER TABLE `tbl_tooltip_display` ADD `on` BOOLEAN NULL DEFAULT TRUE AFTER `user_id`;' );
    }

    public function down()
    {
        $this->execute( 'ALTER TABLE `tbl_tooltip_display` DROP `on`;' );
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
