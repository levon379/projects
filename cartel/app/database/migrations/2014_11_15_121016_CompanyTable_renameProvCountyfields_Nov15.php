<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompanyTableRenameProvCountyfieldsNov15 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE company CHANGE prov province_id integer');
		DB::statement('ALTER TABLE company CHANGE country country_id integer');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE company CHANGE province_id prov integer');
		DB::statement('ALTER TABLE company CHANGE country_id country integer)');
	}

}
