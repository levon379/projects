<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductTypeTableAddfieldTaxGroupNov15 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_type', function(Blueprint $table)
		{
			$table->integer('tax_group')->after('bgcolor')->default(0);
			$table->integer('brokerage_group')->after('tax_group')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('product_type', function(Blueprint $table)
		{
			 $table->dropColumn('tax_group');
			 $table->dropColumn('brokerage_group');
		});
	}

}
