<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderTableRenameShippingfieldNov15 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
			DB::statement('ALTER TABLE cartel_db.order CHANGE shipping brokerage FLOAT(10,2)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
			DB::statement('ALTER TABLE cartel_db.order CHANGE brokerage shipping FLOAT(10,0)');
	}

}
