<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MultipleTablesChangeCurrencyFieldToDecimalNov15 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE product MODIFY COLUMN price decimal(15,2)');
		DB::statement('ALTER TABLE bid MODIFY COLUMN price decimal(15,2)');
		DB::statement('ALTER TABLE `order` MODIFY COLUMN per_item_discount decimal(15,2)');
		DB::statement('ALTER TABLE `order` MODIFY COLUMN brokerage decimal(15,2)');
		DB::statement('ALTER TABLE brokerage MODIFY COLUMN rate decimal(15,2)');
		DB::statement('ALTER TABLE order_misc_charge MODIFY COLUMN price decimal(15,2)');
		DB::statement('ALTER TABLE tax MODIFY COLUMN rate decimal(15,2)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE product MODIFY COLUMN price float(10,2)');
		DB::statement('ALTER TABLE order_misc_charge MODIFY COLUMN price float(10,2)');
		DB::statement('ALTER TABLE `order` MODIFY COLUMN per_item_discount float(10,2)');
		DB::statement('ALTER TABLE `order` MODIFY COLUMN brokerage float(10,2)');
		DB::statement('ALTER TABLE brokerage MODIFY COLUMN   float(10,2)');
		DB::statement('ALTER TABLE order_misc_charge MODIFY COLUMN price float(10,2)');
		DB::statement('ALTER TABLE tax MODIFY COLUMN rate float(10,2)');
	}

}
