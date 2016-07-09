<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterWeightTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('weight_type', function($table)
		{
			$table->double('value_wrt_grams',15,8)->after('isbulk');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('weight_type', function($table)
		{
		 $table->dropColumn('value_wrt_grams');
		});
	}

}
