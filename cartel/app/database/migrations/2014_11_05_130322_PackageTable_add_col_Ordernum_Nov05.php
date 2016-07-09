<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PackageTableAddColOrdernumNov05 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::table('package', function($table)
		{
			$table->integer('ordernum')->after('isbulk');
		});


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('package', function(Blueprint $table)
		{
			 $table->dropColumn('ordernum');
		});

	}

}
