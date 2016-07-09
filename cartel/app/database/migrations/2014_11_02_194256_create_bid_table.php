<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBidTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bid', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('locale_id')->unsigned();
			$table->integer('language_id')->unsigned();
			$table->integer('user_id');
			$table->boolean('bid_viewed')->default(false);
			$table->string('bid_type', 4);
			$table->integer('product_id');
			$table->integer('qty')->nullable();
			$table->float('price', 10, 0)->nullable();
			$table->integer('origin_id')->nullable();
			$table->integer('category_id')->nullable();
			$table->integer('product_type_id')->nullable();
			$table->integer('province_id')->nullable();
			$table->integer('isbulk')->nullable();
			$table->integer('bulk_weight')->nullable();
			$table->integer('bulk_weight_type_id')->nullable();
			$table->integer('bulk_package_id')->nullable();
			$table->integer('carton_pieces')->nullable();
			$table->integer('carton_weight')->nullable();
			$table->integer('carton_weight_type_id')->nullable();
			$table->integer('carton_package_id')->nullable();
			$table->integer('maturity_id')->nullable();
			$table->integer('colour_id')->nullable();
			$table->integer('quality_id')->nullable();
			$table->dateTime('availability_start')->nullable();
			$table->dateTime('availability_end')->nullable();
			$table->text('description')->nullable();
			$table->integer('company_address_id')->nullable();
			$table->integer('status_id')->nullable();
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
		Schema::drop('bid');
	}

}
