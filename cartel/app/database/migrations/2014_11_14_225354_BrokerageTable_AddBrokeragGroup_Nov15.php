<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BrokerageTableAddBrokeragGroupNov15 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('brokerage', function(Blueprint $table)
		{
			$table->integer('brokerage_group')->after('end_date')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('brokerage', function(Blueprint $table)
		{
			 $table->dropColumn('brokerage_group');
		});
	}

}
