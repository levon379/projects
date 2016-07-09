<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContentTableAddLocaleIDFieldDec04 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('content', function(Blueprint $table)
		{
			$table->integer('locale_id')->after('id')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('content', function(Blueprint $table)
		{
			 $table->dropColumn('locale_id');
		});
	}

}
