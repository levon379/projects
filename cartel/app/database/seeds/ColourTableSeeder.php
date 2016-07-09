<?php

class ColourTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('colour')->truncate();
        
		\DB::table('colour')->insert(array (
			0 => 
			array (
				'id' => 1,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Black',
				'ordernum' => 10,
				'status_id' => 16,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-11-02 21:37:05',
			),
			1 => 
			array (
				'id' => 2,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Grafitti',
				'ordernum' => 20,
				'status_id' => 16,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-11-02 21:37:05',
			),
			2 => 
			array (
				'id' => 3,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Green',
				'ordernum' => 30,
				'status_id' => 16,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-11-02 21:05:03',
			),
			3 => 
			array (
				'id' => 4,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Orange',
				'ordernum' => 40,
				'status_id' => 16,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-10-16 00:00:00',
			),
			4 => 
			array (
				'id' => 5,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Purple',
				'ordernum' => 50,
				'status_id' => 16,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-10-16 00:00:00',
			),
			5 => 
			array (
				'id' => 6,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Rainbow',
				'ordernum' => 60,
				'status_id' => 16,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-10-16 00:00:00',
			),
			6 => 
			array (
				'id' => 7,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Red',
				'ordernum' => 70,
				'status_id' => 16,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-10-16 00:00:00',
			),
			7 => 
			array (
				'id' => 8,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Stop Light',
				'ordernum' => 80,
				'status_id' => 16,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-10-16 00:00:00',
			),
			8 => 
			array (
				'id' => 9,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'White',
				'ordernum' => 90,
				'status_id' => 16,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-10-16 00:00:00',
			),
			9 => 
			array (
				'id' => 10,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Yellow',
				'ordernum' => 100,
				'status_id' => 16,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-10-16 00:00:00',
			),
			10 => 
			array (
				'id' => 11,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Other',
				'ordernum' => 110,
				'status_id' => 16,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-11-02 21:54:52',
			),
			11 => 
			array (
				'id' => 12,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Peter',
				'ordernum' => 0,
				'status_id' => 18,
				'created_at' => '2014-11-02 21:26:00',
				'updated_at' => '2014-11-02 21:26:33',
			),
			12 => 
			array (
				'id' => 13,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Peter q',
				'ordernum' => 0,
				'status_id' => 18,
				'created_at' => '2014-11-02 21:30:13',
				'updated_at' => '2014-11-02 21:37:14',
			),
			13 => 
			array (
				'id' => 14,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Peter q2',
				'ordernum' => 0,
				'status_id' => 18,
				'created_at' => '2014-11-02 21:48:21',
				'updated_at' => '2014-11-03 22:38:30',
			),
			14 => 
			array (
				'id' => 15,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Peter',
				'ordernum' => 0,
				'status_id' => 18,
				'created_at' => '2014-11-03 22:39:17',
				'updated_at' => '2014-11-03 22:51:16',
			),
		));
	}

}
