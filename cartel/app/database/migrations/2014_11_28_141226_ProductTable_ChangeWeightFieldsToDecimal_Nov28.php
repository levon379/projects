<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductTableChangeWeightFieldsToDecimalNov28 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE product MODIFY COLUMN bulk_weight decimal(15,2)');
		DB::statement('ALTER TABLE product MODIFY COLUMN carton_weight decimal(15,2)');
		DB::statement('ALTER TABLE product MODIFY COLUMN carton_weight_type_id integer');
		DB::statement('ALTER TABLE product MODIFY COLUMN carton_package_id integer');
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
			//
		});
	}

}
