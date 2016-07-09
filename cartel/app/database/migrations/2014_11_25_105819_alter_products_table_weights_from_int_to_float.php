<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductsTableWeightsFromIntToFloat extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE product CHANGE carton_weight carton_weight decimal(10, 2)');
		DB::statement('ALTER TABLE product CHANGE bulk_weight bulk_weight decimal(10, 2)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE product CHANGE carton_weight carton_weight integer(11)');
		DB::statement('ALTER TABLE product CHANGE bulk_weight bulk_weight integer(11)');
	}

}
?>
