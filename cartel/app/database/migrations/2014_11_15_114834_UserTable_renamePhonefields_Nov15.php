<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTableRenamePhonefieldsNov15 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE user CHANGE cellphone cell_phone varchar(20)');
		DB::statement('ALTER TABLE user CHANGE officephone office_phone varchar(20)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE user CHANGE cell_phone cellphone varchar(20)');
		DB::statement('ALTER TABLE user CHANGE office_phone officephone varchar(20)');
	}

}
