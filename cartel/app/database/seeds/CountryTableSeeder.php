<?php

class CountryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('country')->truncate();
        
		\DB::table('country')->insert(array (
			0 => 
			array (
				'id' => 1,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Canada',
				'code' => 'CA',
				'status_id' => 41,
				'created_at' => '2014-10-17 04:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'United States of America',
				'code' => 'US',
				'status_id' => 41,
				'created_at' => '2014-10-17 04:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
