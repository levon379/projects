<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MultipleTablesRenameBrokerageTaxGroupfieldsNov16 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE brokerage CHANGE brokerage_group brokerage_group_id integer');
		DB::statement('ALTER TABLE tax CHANGE tax_group tax_group_id integer');
		DB::statement('ALTER TABLE `order` CHANGE brokerage_group brokerage_group_id integer');
		DB::statement('ALTER TABLE `order` CHANGE tax_group tax_group_id integer');
		DB::statement('ALTER TABLE `order` CHANGE seller_discount per_item_discount float(10,2)');
		DB::statement('ALTER TABLE product_type CHANGE brokerage_group brokerage_group_id integer');
		DB::statement('ALTER TABLE product_type CHANGE tax_group tax_group_id integer');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE brokerage CHANGE brokerage_group_id brokerage_group integer');
		DB::statement('ALTER TABLE tax CHANGE tax_group_id tax_group integer');
		DB::statement('ALTER TABLE `order` CHANGE brokerage_group_id brokerage_group integer');
		DB::statement('ALTER TABLE `order` CHANGE tax_group_id tax_group integer');
		DB::statement('ALTER TABLE `order` CHANGE per_item_discount seller_discount float(10,2)');
		DB::statement('ALTER TABLE product_type CHANGE brokerage_group_id brokerage_group integer');
		DB::statement('ALTER TABLE product_type CHANGE tax_group_id tax_group integer');
	}

}
