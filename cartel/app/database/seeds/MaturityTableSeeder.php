<?php

class MaturityTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('maturity')->truncate();
        
		\DB::table('maturity')->insert(array (
			0 => 
			array (
				'id' => 1,
				'locale_id' => 1,
				'language_id' => 1,
				//'category_id' => 0,
				'name' => '0   to 20%',
				'ordernum' => 10,
				'status_id' => 19,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-10-16 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'locale_id' => 1,
				'language_id' => 1,
				//'category_id' => 0,
				'name' => '20 to 40%',
				'ordernum' => 20,
				'status_id' => 19,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-10-16 00:00:00',
			),
			2 => 
			array (
				'id' => 3,
				'locale_id' => 1,
				'language_id' => 1,
				//'category_id' => 0,
				'name' => '40 to 60%',
				'ordernum' => 30,
				'status_id' => 19,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-10-16 00:00:00',
			),
			3 => 
			array (
				'id' => 4,
				'locale_id' => 1,
				'language_id' => 1,
				//'category_id' => 0,
				'name' => '60 to 80%',
				'ordernum' => 40,
				'status_id' => 19,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-10-16 00:00:00',
			),
			4 => 
			array (
				'id' => 5,
				'locale_id' => 1,
				'language_id' => 1,
				//'category_id' => 0,
				'name' => '80 to 100%',
				'ordernum' => 50,
				'status_id' => 19,
				'created_at' => '2014-10-16 00:00:00',
				'updated_at' => '2014-10-16 00:00:00',
			),
		));
	}

}
