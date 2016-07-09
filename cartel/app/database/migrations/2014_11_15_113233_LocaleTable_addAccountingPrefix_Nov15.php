<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LocaleTableAddAccountingPrefixNov15 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('locale', function(Blueprint $table)
		{
			$table->string('accounting_prefix')->after('name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('locale', function(Blueprint $table)
		{
			 $table->dropColumn('accounting_prefix');
		});
	}

}
