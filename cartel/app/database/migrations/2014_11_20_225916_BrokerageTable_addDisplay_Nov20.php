<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BrokerageTableAddDisplayNov20 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('brokerage', function(Blueprint $table)
		{
			$table->string('display')->after('rate');
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
			 $table->dropColumn('display');
		});
	}

}
