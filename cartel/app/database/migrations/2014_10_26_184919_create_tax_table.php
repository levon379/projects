<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tax', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('locale_id')->unsigned();
			$table->timestamps();
			$table->string('name', 45);
			$table->float('rate', 10, 0);
			$table->dateTime('start_date')->default('0000-00-00 00:00:00');
			$table->dateTime('end_date')->default('0000-00-00 00:00:00');
			$table->integer('tax_group');
			$table->integer('language_id')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tax');
	}

}
