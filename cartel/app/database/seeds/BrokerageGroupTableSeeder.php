<?php

class BrokerageGroupTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('brokerage_group')->truncate();
        
		\DB::table('brokerage_group')->insert(array (
			0 => 
			array (
				'id' => 1,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'No Brokerage Fees',
				'status_id' => 76,
				'created_at' => '2014-11-14 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Produce',
				'status_id' => 76,
				'created_at' => '2014-11-14 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
