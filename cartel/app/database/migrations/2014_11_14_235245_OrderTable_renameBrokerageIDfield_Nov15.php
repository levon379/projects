<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderTableRenameBrokerageIDfieldNov15 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE cartel_db.order CHANGE brokerage_id brokerage_group integer');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('order', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE cartel_db.order CHANGE brokerage_group brokerage_id integer');
		});
	}

}
