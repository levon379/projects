<?php

use yii\db\Schema;
use yii\db\Migration;

class m150629_055805_tbl_post_template_image extends Migration
{
    public function up(){
		$this->execute( 'CREATE TABLE IF NOT EXISTS `tbl_post_template_image` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `post_template_id` int(11) NOT NULL,
						  `file_name` varchar(255) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;' );
    }

    public function down(){
        $this->dropTable('tbl_post_template_image');
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
