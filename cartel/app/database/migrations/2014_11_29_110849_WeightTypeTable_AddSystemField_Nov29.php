<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WeightTypeTableAddSystemFieldNov29 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('weight_type', function(Blueprint $table)
{
			$table->string('system')->after('value_wrt_grams');
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
			 $table->dropColumn('system');
		});
	}

}
