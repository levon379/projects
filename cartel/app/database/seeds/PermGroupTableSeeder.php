<?php

class PermGroupTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('perm_group')->truncate();
        
		\DB::table('perm_group')->insert(array (
			0 => 
			array (
				'id' => 1,
			'name' => 'SuperUser (Peter)',
				'moduleperms' => 68719476734,
				'status_id' => 5,
				'ordernum' => 0,
				'created_at' => '2014-10-10 04:00:00',
				'updated_at' => '2014-10-10 04:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'Site Owner',
				'moduleperms' => 1073496062,
				'status_id' => 5,
				'ordernum' => 10,
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 23:33:00',
			),
			2 => 
			array (
				'id' => 4,
				'name' => 'Cartel Staff',
				'moduleperms' => 1073496062,
				'status_id' => 5,
				'ordernum' => 20,
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			3 => 
			array (
				'id' => 8,
				'name' => 'Locale Board Owner',
				'moduleperms' => 0,
				'status_id' => 5,
				'ordernum' => 30,
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			4 => 
			array (
				'id' => 16,
				'name' => 'Company User',
				'moduleperms' => 254,
				'status_id' => 5,
				'ordernum' => 40,
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 23:33:58',
			),
			5 => 
			array (
				'id' => 32,
				'name' => 'PostToSellOnly',
				'moduleperms' => 15374,
				'status_id' => 5,
				'ordernum' => 50,
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 23:34:11',
			),
			6 => 
			array (
				'id' => 64,
				'name' => 'Board-Only user',
				'moduleperms' => 14,
				'status_id' => 5,
				'ordernum' => 60,
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 23:34:22',
			),
			7 => 
			array (
				'id' => 128,
				'name' => 'Visitor',
				'moduleperms' => 4,
				'status_id' => 5,
				'ordernum' => 70,
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 23:34:34',
			),
		));
	}

}
