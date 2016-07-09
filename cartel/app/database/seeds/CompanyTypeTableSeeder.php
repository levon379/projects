<?php

class CompanyTypeTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('company_type')->truncate();
        
		\DB::table('company_type')->insert(array (
			0 => 
			array (
				'id' => 1,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Standard',
				'description' => 'Typical Produce Company',
				'brokerage_id' => 0,
				'receive_board_emails' => 1,
				'credit_limits_apply' => 1,
				'status_id' => 80,
				'created_at' => '2014-11-18 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Trucking',
				'description' => 'Trucking/Freight Company',
				'brokerage_id' => 0,
				'receive_board_emails' => 0,
				'credit_limits_apply' => 0,
				'status_id' => 80,
				'created_at' => '2014-11-18 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
