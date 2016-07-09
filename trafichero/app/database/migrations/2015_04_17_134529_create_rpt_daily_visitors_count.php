<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRptDailyVisitorsCount extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::dropIfExists('rpt_daily_visitors_count');
            Schema::create('rpt_daily_visitors_count', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('site_id')->unsigned()->default(NULL);
                $table->integer('last_day_visitors')->default(NULL);
                $table->foreign('site_id')
                        ->references('idsite')
                        ->on('piwik_site')
                        ->onUpdate('cascade')
                        ->onDelete('cascade');
//                $table->timestamps();
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::dropIfExists('rpt_daily_visitors_count');
	}

}
