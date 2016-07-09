<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('content', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('language_id')->unsigned();
			$table->string('name', 45);
			$table->text('content');
			$table->string('type', 15)->nullable();
			$table->string('content_group', 15)->nullable();
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
		Schema::drop('Content');
	}

}
