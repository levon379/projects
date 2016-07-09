<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BidTableAddAccepterIDfieldNov09 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bid', function($table)
		{
			$table->integer('accepter_id')->after('user_id')->default(0);
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bid', function(Blueprint $table)
		{
			 $table->dropColumn('accepter_id');
		});
	}

}
