<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BidTableChangePriceDataTypeNov09 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
			DB::statement('ALTER TABLE bid MODIFY COLUMN price float(10,2)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
			DB::statement('ALTER TABLE bid MODIFY COLUMN price float(10,0)');
	}

}
