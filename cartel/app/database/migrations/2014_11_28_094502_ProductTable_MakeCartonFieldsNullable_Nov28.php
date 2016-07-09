<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductTableMakeCartonFieldsNullableNov28 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `product` MODIFY `carton_weight` float(5,2) NULL;');
			DB::statement('ALTER TABLE `product` MODIFY `carton_weight_type_id` float(5,2) NULL;');
			DB::statement('ALTER TABLE `product` MODIFY `carton_package_id` float(5,2) NULL;');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('product', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `product` MODIFY `carton_weight` float(5,2);');
			DB::statement('ALTER TABLE `product` MODIFY `carton_weight_type_id` float(5,2);');
			DB::statement('ALTER TABLE `product` MODIFY `carton_package_id` float(5,2);');
		});
	}

}
