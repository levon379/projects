<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('locale_id')->unsigned();
			$table->integer('language_id')->unsigned();
			$table->string('name', 45)->nullable();
			$table->integer('parent_id')->nullable();
			$table->integer('isother')->nullable();
			$table->integer('status_id')->nullable();
			$table->integer('ordernum')->nullable();
			$table->string('bgcolor1', 10)->nullable();
			$table->string('bgcolor2', 10)->nullable();
			$table->string('bgcolor3', 10)->nullable();
			$table->integer('brokerage_id');
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
		Schema::drop('category');
	}

}
