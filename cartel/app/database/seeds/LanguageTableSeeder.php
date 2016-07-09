<?php

class LanguageTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('language')->truncate();
        
		\DB::table('language')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'English',
				'code' => 'en',
				'status_id' => 7,
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'French',
				'code' => 'fr',
				'status_id' => 7,
			),
		));
	}

}
