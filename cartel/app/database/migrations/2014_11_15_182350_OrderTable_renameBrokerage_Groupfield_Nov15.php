	<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderTableRenameBrokerageGroupfieldNov15 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('order', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `order` CHANGE brokerage_group_id brokerage_id integer');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('order', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `order` CHANGE brokerage_id brokerage_group_id integer');
		});
	}

}
