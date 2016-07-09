<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOriginTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('origin', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('locale_id')->unsigned();
			$table->integer('language_id')->unsigned();
			$table->string('name', 45)->nullable();
			$table->string('image', 45)->nullable();
			$table->integer('status_id')->unsigned();
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
		Schema::drop('origin');
	}

}
