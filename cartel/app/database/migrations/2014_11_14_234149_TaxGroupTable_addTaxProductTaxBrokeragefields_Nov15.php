<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaxGroupTableAddTaxProductTaxBrokeragefieldsNov15 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tax_group', function(Blueprint $table)
		{
			$table->integer('tax_product')->after('name')->default(0);
			$table->integer('tax_brokerage')->after('tax_product')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tax_group', function(Blueprint $table)
		{
			 $table->dropColumn('tax_product');
			 $table->dropColumn('tax_brokerage');
		});
	}

}
