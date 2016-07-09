<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToPiwikSite extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $fk = DB::select(DB::raw("select 
            TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
            from INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            where REFERENCED_TABLE_NAME = 'piwik_user' AND TABLE_NAME = 'piwik_site';"));
        if(!empty($fk)) {
            $foreign_key = $fk[0]->CONSTRAINT_NAME;
            $sql = "ALTER TABLE piwik_site DROP FOREIGN KEY ".$foreign_key.";";
            DB::statement($sql);
        }
        
        $sql_index = "SHOW INDEX FROM piwik_site WHERE column_name = 'user_id'";
        $res_index = DB::select($sql_index);
        if(!empty($res_index)) {
            $index = $res_index[0]->Key_name;
            $sql = "ALTER TABLE piwik_site DROP INDEX ".$index.";";
            DB::statement($sql);
        }
        
        DB::statement('ALTER TABLE `piwik_site` ADD CONSTRAINT `fk_piwik_site_piwik_user` FOREIGN KEY (`user_id`) REFERENCES `piwik_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $fk = DB::select(DB::raw("select 
            TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
            from INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            where REFERENCED_TABLE_NAME = 'piwik_user';"));
        if(!empty($fk)) {
            $foreign_key = $fk[0]->CONSTRAINT_NAME;
            $sql = "ALTER TABLE piwik_site DROP FOREIGN KEY ".$foreign_key.";";
            DB::statement($sql);
        }
        
        $sql_index = "SHOW INDEX FROM piwik_site WHERE column_name = 'user_id'";
        $res_index = DB::select($sql_index);
        if(!empty($res_index)) {
            $index = $res_index[0]->Key_name;
            $sql = "ALTER TABLE piwik_site DROP INDEX ".$index.";";
            DB::statement($sql);
        }
    }

}
