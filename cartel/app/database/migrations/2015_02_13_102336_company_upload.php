<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompanyUpload extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_upload', function($t)
		{
			$t->integer('id')->unique();
			$t->integer('locale_id');
			$t->integer('language_id');
			$t->integer('company_id');
			$t->string('filename', 255);
			$t->string('name', 255);
			$t->text('description');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
