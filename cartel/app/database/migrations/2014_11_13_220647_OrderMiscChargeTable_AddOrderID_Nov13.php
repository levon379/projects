<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderMiscChargeTableAddOrderIDNov13 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('order_misc_charge', function(Blueprint $table)
		{
			$table->integer('order_id')->after('id')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('order_misc_charge', function(Blueprint $table)
		{
			 $table->dropColumn('order_id');
		});
	}

}
