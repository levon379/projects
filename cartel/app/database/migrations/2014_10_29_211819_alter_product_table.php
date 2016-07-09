<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product', function($table)
		{
			 $table->dropColumn('display_address');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('product', function($table)
		{
      //$table->integer('display_address',15,8)->after('company_address_id');
			$table->integer('display_address')->nullable();
		});
	}

}
