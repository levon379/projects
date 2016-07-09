<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('locale_id')->unsigned();
			$table->integer('language_id')->unsigned();
			$table->string('bid_type', 4)->nullable();
			$table->dateTime('order_date')->nullable();
			$table->integer('accepter_id')->unsigned();
			$table->float('sellerdiscount', 10, 0)->nullable();
			$table->integer('receivable_status_id')->unsigned();
			$table->integer('payable_status_id')->unsigned();
			$table->float('shipping', 10, 0)->nullable();
			$table->integer('shipped_qty')->nullable();
			$table->integer('received_qty')->nullable();
			$table->integer('tax_group')->unsigned();
			$table->integer('brokerage_id')->unsigned();
			$table->string('customerPO', 45)->nullable();
			$table->string('customerPO_comments')->nullable();
			$table->integer('transport_brokerage_id')->unsigned();
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
		Schema::drop('order');
	}

}
