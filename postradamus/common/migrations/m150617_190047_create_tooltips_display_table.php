<?php

use yii\db\Schema;
use yii\db\Migration;

class m150617_190047_create_tooltips_display_table extends Migration
{
    public function up()
    {
		$this->execute( 'CREATE TABLE IF NOT EXISTS `tbl_tooltip_display` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `user_id` int(11) NOT NULL,
						  `disabled_tooltips` text NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1;' );
    }

    public function down()
    {
        $this->dropTable('tbl_tooltip_display');
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
