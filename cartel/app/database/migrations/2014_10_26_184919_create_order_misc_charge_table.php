<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderMiscChargeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_misc_charge', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('company_id')->unsigned();
			$table->dateTime('charge_date')->nullable();
			$table->string('vendor_buyer', 10)->nullable();
			$table->float('price', 10, 0)->nullable();
			$table->integer('tax_group');
			$table->string('description')->nullable();
			$table->integer('status_id')->unsigned();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_misc_charge');
	}

}
