<?php

class CompanyTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('company')->truncate();
        
		\DB::table('company')->insert(array (
			0 => 
			array (
				'id' => 2,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Cartel Marketing',
				'address' => '4 Nicholas Dr',
				'address2' => '',
				'city' => 'Leamington',
				'postal_code' => 'N8H 3R8',
				'province_id' => 2,
				'country_id' => 1,
				'default_email' => 'info@cartelmarketing.org',
				'website' => 'www.cartelmarketing.org',
				'phone' => '519-325-0111',
				'fax' => '519-973-6222',
				'status_id' => 13,
				'message' => NULL,
				'credit_limit' => 1000000,
				'credit_limit_exp' => '2020-01-01 00:00:00',
				'ap_email' => 'info@cartelmarketing.org',
				'ar_email' => 'info@cartelmarketing.org',
				'shipping_email' => 'info@cartelmarketing.org',
				'receiving_email' => 'info@cartelmarketing.org',
				'logistics_email' => 'info@cartelmarketing.org',
				'internal_notes' => NULL,
				'payable_notes' => NULL,
				'created_at' => '2014-10-02 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 3,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'JEV Marketing',
				'address' => '2880 Temple Dr',
				'address2' => '#200',
				'city' => 'Windsor',
				'postal_code' => 'N8W 5J5',
				'province_id' => 2,
				'country_id' => 1,
				'default_email' => 'info@jevmarketing.org',
				'website' => 'www.jevmarketing.com',
				'phone' => '519-966-3094',
				'fax' => '519-966-3887',
				'status_id' => 13,
				'message' => NULL,
				'credit_limit' => 100000,
				'credit_limit_exp' => '2020-01-01 00:00:00',
				'ap_email' => 'info@jevmarketing.org',
				'ar_email' => 'info@jevmarketing.org',
				'shipping_email' => 'peter@peterbechard.com',
				'receiving_email' => 'sales@fourthrealm.com',
				'logistics_email' => 'peter@peterbechard.com',
				'internal_notes' => NULL,
				'payable_notes' => NULL,
				'created_at' => '2014-10-02 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
