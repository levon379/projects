<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_type', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('locale_id')->unsigned();
			$table->integer('language_id')->unsigned();
			$table->string('name', 45);
			$table->string('description', 150)->nullable();
			$table->integer('brokerage_id');
			$table->integer('receive_board_emails')->default(1);
			$table->integer('credit_limits_apply')->default(1);
			$table->integer('status_id');
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
		Schema::drop('company_type');
	}

}
