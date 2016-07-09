<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WeightTypeTableAddColOrdernumNov05 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('weight_type', function($table)
		{
			$table->integer('ordernum')->after('isbulk');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('weight_type', function(Blueprint $table)
		{
			 $table->dropColumn('ordernum');
		});
	}

}
