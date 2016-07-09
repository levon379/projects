<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToRptDailyVisitorsCount extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql_index = "SHOW INDEX FROM rpt_daily_visitors_count WHERE column_name = 'date'";
        $res_index = DB::select($sql_index);
        if(!empty($res_index)) {
            $index = $res_index[0]->Key_name;
            $sql = "ALTER TABLE rpt_daily_visitors_count DROP INDEX ".$index.";";
            DB::statement($sql);
        }
        
        DB::statement("ALTER TABLE `rpt_daily_visitors_count` ADD INDEX `date` (`date`) USING BTREE ;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql_index = "SHOW INDEX FROM rpt_daily_visitors_count WHERE column_name = 'date'";
        $res_index = DB::select($sql_index);
        if(!empty($res_index)) {
            $index = $res_index[0]->Key_name;
            $sql = "ALTER TABLE rpt_daily_visitors_count DROP INDEX ".$index.";";
            DB::statement($sql);
        }
    }

}
