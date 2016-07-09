<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('locale_id')->unsigned();
			$table->integer('language_id')->unsigned();
			$table->string('name', 45)->nullable();
			$table->string('address', 45)->nullable();
			$table->string('address2', 45)->nullable();
			$table->string('city', 45)->nullable();
			$table->string('postcode', 45)->nullable();
			$table->string('prov', 45)->nullable();
			$table->string('country', 45)->nullable();
			$table->string('default_email', 45)->nullable();
			$table->string('website', 45)->nullable();
			$table->string('phone', 45)->nullable();
			$table->string('fax', 45)->nullable();
			$table->integer('status_id')->nullable();
			$table->text('message')->nullable();
			$table->float('credit_limit', 10, 0)->nullable();
			$table->dateTime('credit_limit_exp')->nullable();
			$table->string('ap_email', 45)->nullable();
			$table->string('ar_email', 45)->nullable();
			$table->string('shipping_email', 45)->nullable();
			$table->string('receiving_email', 45)->nullable();
			$table->string('logistics_email', 45)->nullable();
			$table->text('internal_notes')->nullable();
			$table->text('payable_notes')->nullable();
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
		Schema::drop('company');
	}

}
