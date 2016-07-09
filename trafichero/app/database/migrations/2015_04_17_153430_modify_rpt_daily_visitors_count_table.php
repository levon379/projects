<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyRptDailyVisitorsCountTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            DB::statement('ALTER TABLE `rpt_daily_visitors_count` MODIFY `site_id` INTEGER UNSIGNED NULL;');
            DB::statement('ALTER TABLE `rpt_daily_visitors_count` MODIFY `last_day_visitors` INTEGER UNSIGNED NULL;');
            DB::statement('ALTER TABLE `rpt_daily_visitors_count` CHANGE last_day_visitors visits_count INTEGER NULL');
            
            Schema::table('rpt_daily_visitors_count', function(Blueprint $table)
            {
//                $table->renameColumn('last_day_visitors', 'visitors_count');
                $table->date('date')->nullable();
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::table('rpt_daily_visitors_count', function(Blueprint $table)
            {
//                $table->renameColumn('visitors_count', 'last_day_visitors');
                $table->dropColumn('date');
            });
            
            DB::statement('ALTER TABLE `rpt_daily_visitors_count` CHANGE visits_count last_day_visitors INTEGER');
            DB::statement('ALTER TABLE `rpt_daily_visitors_count` MODIFY `last_day_visitors` INTEGER UNSIGNED NOT NULL;');
//            DB::statement('ALTER TABLE `rpt_daily_visitors_count` MODIFY `site_id` INTEGER UNSIGNED NOT NULL;');
	}

}
