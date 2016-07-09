<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QualityTableDropCategoryIDNov05 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('quality', function(Blueprint $table)
		{
			 $table->dropColumn('category_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('quality', function(Blueprint $table)
		{
			$table->integer('category_id')->after('language_id');
		});
	}

}
