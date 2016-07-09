<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PermGroupTableIncraseSizeOfModulePermsInteger extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE perm_group CHANGE moduleperms moduleperms bigint(20)');
		DB::statement('ALTER TABLE perm_module CHANGE id id bigint(20)');
		Schema::table('perm_module', function(Blueprint $table)
		{
			$table->string('sort_group',50)->after('showname');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE perm_group CHANGE moduleperms moduleperms int(11)');
		DB::statement('ALTER TABLE module CHANGE id id int(11)');
		Schema::table('perm_module', function(Blueprint $table)
		{
			 $table->dropColumn('sort_group');
		});

	}

}
