<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermGroupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('perm_group', function(Blueprint $table)
		{
			$table->integer('id')->primary();
			$table->string('name', 45);
			$table->integer('moduleperms')->unsigned();
			$table->integer('status_id');
			$table->integer('ordernum');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('perm_group');
	}

}
