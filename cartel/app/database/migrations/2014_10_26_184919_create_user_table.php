<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('defaultlanguage_id')->unsigned();
			$table->integer('company_id')->unsigned();
			$table->timestamps();
			$table->string('name', 45)->nullable();
			$table->string('email', 45)->nullable();
			$table->string('email2', 45)->nullable();
			$table->string('username', 45)->nullable();
			$table->string('password', 60)->nullable();
			$table->integer('perm_groups')->default(0);
			$table->integer('status_id')->nullable();
			$table->integer('active')->default(1);
			$table->string('pager', 45)->nullable();
			$table->string('officephone', 20)->nullable();
			$table->string('cellphone', 20)->nullable();
			$table->timestamp('last_online');
			$table->string('remember_token', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user');
	}

}
