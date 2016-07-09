<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('locale_id')->unsigned();
			$table->integer('language_id')->unsigned();
			$table->integer('user_id')->default(0);
			$table->string('post_type', 4)->nullable();
			$table->integer('origin_id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->integer('product_type_id')->unsigned();
			$table->integer('province_id')->nullable();
			$table->integer('qty')->nullable();
			$table->integer('minqty')->nullable();
			$table->float('price', 10, 0)->nullable();
			$table->integer('isbulk')->nullable();
			$table->integer('bulk_pieces')->nullable();
			$table->integer('bulk_weight')->nullable();
			$table->integer('bulk_weight_type_id')->unsigned()->nullable();
			$table->integer('bulk_package_id')->unsigned()->nullable();
			$table->integer('carton_weight');
			$table->integer('carton_weight_type_id');
			$table->integer('carton_package_id');
			$table->integer('maturity_id')->unsigned();
			$table->integer('colour_id')->unsigned();
			$table->integer('quality_id')->unsigned();
      
      $today = date('Y-m-d');
			$table->dateTime('availability_start')->default($today . ' 01:00:00');
			$table->dateTime('availability_end')->default($today . ' 23:00:00');
      
      // original values
			//$table->dateTime('availability_start')->default('0000-00-00 00:00:00');
			//$table->dateTime('availability_end')->default('0000-00-00 00:00:00');
      
			$table->text('description')->nullable();
			$table->integer('company_address_id')->unsigned();
			$table->integer('display_address')->nullable();
			$table->integer('status_id')->unsigned();
      
      // Default timestamps
      //$table->timestamps();
      
      // Custom timestamps
      $table->dateTime('created_at')->default($today . ' 00:00:00');
      $table->dateTime('updated_at')->default($today . ' 23:59:59');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product');
	}

}
