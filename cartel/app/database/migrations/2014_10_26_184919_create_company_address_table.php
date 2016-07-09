<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyAddressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_address', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('locale_id')->unsigned();
			$table->integer('language_id')->unsigned();
			$table->integer('company_id');
			$table->string('ship_or_recv', 4)->nullable();
			$table->string('address', 45)->nullable();
			$table->string('address2', 45)->nullable();
			$table->string('city', 45)->nullable();
			$table->string('postal_code', 45)->nullable();
			$table->integer('province_id')->nullable();
			$table->integer('country_id')->nullable();
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
		Schema::drop('company_address');
	}

}
