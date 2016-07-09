<?php

class BrokerageTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('brokerage')->truncate();
        
		\DB::table('brokerage')->insert(array (
			0 => 
			array (
				'id' => 1,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Minimum',
				'type' => 'base',
				'rate' => '150.00',
				'display' => '$:rate: min',
				'start_date' => '1950-01-01 00:00:00',
				'end_date' => '2099-01-01 23:59:59',
				'brokerage_group_id' => 2,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Per Item',
				'type' => 'dollar',
				'rate' => '0.25',
				'display' => '$:rate:/ pkg',
				'start_date' => '1950-01-01 00:00:00',
				'end_date' => '2099-01-01 23:59:59',
				'brokerage_group_id' => 2,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			2 => 
			array (
				'id' => 3,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Percent',
				'type' => 'percent',
				'rate' => '0.15',
				'display' => ':rate: %',
				'start_date' => '1950-01-01 00:00:00',
				'end_date' => '2099-01-01 23:59:59',
				'brokerage_group_id' => 2,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			3 => 
			array (
				'id' => 4,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'No Brokerage',
				'type' => 'base',
				'rate' => '0.00',
				'display' => '$0 minimum',
				'start_date' => '1950-01-01 00:00:00',
				'end_date' => '2099-01-01 23:59:59',
				'brokerage_group_id' => 1,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
