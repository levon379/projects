<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyDocTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_doc', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('company_id')->unsigned();
			$table->string('name', 45)->nullable();
			$table->string('filename', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('company_doc');
	}

}
