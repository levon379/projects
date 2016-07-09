<?php

class LocaleTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('locale')->truncate();
        
		\DB::table('locale')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'Windsor/Essex',
				'accounting_prefix' => 'W',
				'status_id' => 10,
				'languages' => '1,2',
				'default_language_id' => 1,
				'created_at' => '2014-10-02 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
