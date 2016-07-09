<?php

class CompanyAddressTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('company_address')->truncate();
        
		\DB::table('company_address')->insert(array (
			0 => 
			array (
				'id' => 1,
				'locale_id' => 1,
				'language_id' => 1,
				'company_id' => 2,
				'ship_or_recv' => 'Both',
				'address' => '4 Nicholas St',
				'address2' => '',
				'city' => 'Leamington',
				'postal_code' => 'N8N3R8',
				'province_id' => 2,
				'country_id' => 1,
				'status_id' => 50,
				'created_at' => '2014-10-17 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'locale_id' => 1,
				'language_id' => 1,
				'company_id' => 3,
				'ship_or_recv' => 'Recv',
				'address' => '2880 Temple Dr',
				'address2' => 'Unit 5',
				'city' => 'Windsor',
				'postal_code' => 'N8W5J5',
				'province_id' => 2,
				'country_id' => 1,
				'status_id' => 50,
				'created_at' => '2014-10-17 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			2 => 
			array (
				'id' => 3,
				'locale_id' => 1,
				'language_id' => 1,
				'company_id' => 3,
				'ship_or_recv' => 'Both',
				'address' => '123 Fake St.',
				'address2' => NULL,
				'city' => 'Windsor',
				'postal_code' => 'N94 G4A',
				'province_id' => 2,
				'country_id' => 1,
				'status_id' => 50,
				'created_at' => '2014-10-17 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			3 => 
			array (
				'id' => 6,
				'locale_id' => 1,
				'language_id' => 1,
				'company_id' => 3,
				'ship_or_recv' => 'Recv',
				'address' => 'Other_123 That St',
				'address2' => NULL,
				'city' => 'Other_Windsor',
				'postal_code' => 'N8N 1J1',
				'province_id' => 2,
				'country_id' => 1,
				'status_id' => 50,
				'created_at' => '2014-10-20 00:26:37',
				'updated_at' => '2014-10-20 00:26:37',
			),
		));
	}

}
