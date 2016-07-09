<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompanyAddressTableAddCompanyNameFieldNov29 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('company_address', function(Blueprint $table)
		{
			$table->string('company',50)->after('ship_or_recv');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('company_address', function(Blueprint $table)
		{
			 $table->dropColumn('company');
		});
	}

}
