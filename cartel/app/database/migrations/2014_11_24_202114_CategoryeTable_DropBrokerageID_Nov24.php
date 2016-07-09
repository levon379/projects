<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoryeTableDropBrokerageIDNov24 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('category', function(Blueprint $table)
		{
			 $table->dropColumn('brokerage_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('category', function(Blueprint $table)
		{
			$table->integer('brokerage_id')->after('bgcolor3');
		});
	}

}
