<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderTableRenameSellerDiscountNov09 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE cartel_db.order CHANGE sellerdiscount seller_discount float(10,2)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE cartel_db.order CHANGE seller_discount sellerdiscount float(10,2)');
	}

}
