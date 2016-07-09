<?php

class PackageTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('package')->truncate();
        
		\DB::table('package')->insert(array (
			0 => 
			array (
				'id' => 19,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Celo',
				'isbulk' => 0,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			1 => 
			array (
				'id' => 20,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Clam Shell',
				'isbulk' => 0,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			2 => 
			array (
				'id' => 21,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => '2 count',
				'isbulk' => 0,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			3 => 
			array (
				'id' => 22,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => '3 count',
				'isbulk' => 0,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			4 => 
			array (
				'id' => 23,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => '4 count',
				'isbulk' => 0,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			5 => 
			array (
				'id' => 24,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => '5 count',
				'isbulk' => 0,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			6 => 
			array (
				'id' => 25,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => '6 count',
				'isbulk' => 0,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			7 => 
			array (
				'id' => 26,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Netted Bag',
				'isbulk' => 0,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			8 => 
			array (
				'id' => 27,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Poly Bag',
				'isbulk' => 0,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			9 => 
			array (
				'id' => 28,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Single',
				'isbulk' => 0,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			10 => 
			array (
				'id' => 29,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Single Wrapped',
				'isbulk' => 0,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			11 => 
			array (
				'id' => 30,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Tray Wrapped',
				'isbulk' => 0,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			12 => 
			array (
				'id' => 31,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Other',
				'isbulk' => 0,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			13 => 
			array (
				'id' => 32,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Bag',
				'isbulk' => 1,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			14 => 
			array (
				'id' => 33,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Carton',
				'isbulk' => 1,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			15 => 
			array (
				'id' => 34,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Crate',
				'isbulk' => 1,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			16 => 
			array (
				'id' => 35,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Flat',
				'isbulk' => 1,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			17 => 
			array (
				'id' => 36,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Tote',
				'isbulk' => 1,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
			18 => 
			array (
				'id' => 37,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Other',
				'isbulk' => 1,
				'status_id' => 29,
				'created_at' => '2014-10-16 21:00:00',
				'updated_at' => '2014-10-16 21:00:00',
			),
		));
	}

}
