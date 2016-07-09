<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWeightTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('weight_type', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('locale_id')->unsigned();
			$table->integer('language_id')->unsigned();
			$table->string('name', 45)->nullable();
			$table->integer('isbulk')->nullable();
			//$table->string('system', 255)->nullable();
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
		Schema::drop('weight_type');
	}

}
