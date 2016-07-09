<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTableAddLoginRelatedFieldsDec04 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user', function(Blueprint $table)
		{
			$table->integer('login_attempts')->after('remember_token')->default(0);
			$table->integer('lockout_time')->after('login_attempts')->default(0);
			$table->integer('is_online')->after('lockout_time')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user', function(Blueprint $table)
		{
			 $table->dropColumn('login_attempts');
			 $table->dropColumn('lockout_time');
			 $table->dropColumn('is_online');
		});
	}

}
