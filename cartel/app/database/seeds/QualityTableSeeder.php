<?php

class QualityTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('quality')->truncate();
        
		\DB::table('quality')->insert(array (
			0 => 
			array (
				'id' => 1,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Excellent',
				'ordernum' => 10,
				'status_id' => 26,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-10-16 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Good',
				'ordernum' => 20,
				'status_id' => 26,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-10-16 00:00:00',
			),
			2 => 
			array (
				'id' => 3,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Fair',
				'ordernum' => 30,
				'status_id' => 26,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-11-05 19:16:45',
			),
			3 => 
			array (
				'id' => 4,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Poor',
				'ordernum' => 40,
				'status_id' => 26,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-11-05 19:16:45',
			),
			4 => 
			array (
				'id' => 5,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Peter',
				'ordernum' => 0,
				'status_id' => 28,
				'created_at' => '2014-11-05 18:52:52',
				'updated_at' => '2014-11-05 19:12:08',
			),
			5 => 
			array (
				'id' => 6,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'peter',
				'ordernum' => 0,
				'status_id' => 28,
				'created_at' => '2014-11-05 18:54:34',
				'updated_at' => '2014-11-05 19:13:25',
			),
			6 => 
			array (
				'id' => 7,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Peter 16',
				'ordernum' => 0,
				'status_id' => 28,
				'created_at' => '2014-11-05 18:55:27',
				'updated_at' => '2014-11-05 19:13:43',
			),
			7 => 
			array (
				'id' => 8,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Pete 17',
				'ordernum' => 0,
				'status_id' => 28,
				'created_at' => '2014-11-05 18:55:56',
				'updated_at' => '2014-11-05 19:04:20',
			),
			8 => 
			array (
				'id' => 9,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Peter q2',
				'ordernum' => 0,
				'status_id' => 28,
				'created_at' => '2014-11-05 18:56:08',
				'updated_at' => '2014-11-05 19:13:46',
			),
		));
	}

}
