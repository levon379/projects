<?php

class ConfigurationTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('configuration')->truncate();
        
		\DB::table('configuration')->insert(array (
			0 => 
			array (
				'id' => 1,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'companyName',
				'cvalue' => 'Cartel Marketing Inc',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'companyAddress',
				'cvalue' => '4 Nicholas Dr',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			2 => 
			array (
				'id' => 3,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'companyAddress2',
				'cvalue' => NULL,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			3 => 
			array (
				'id' => 4,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'companyCity',
				'cvalue' => 'Leamington',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			4 => 
			array (
				'id' => 5,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'companyPostal',
				'cvalue' => 'N8H 3R8',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			5 => 
			array (
				'id' => 6,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'companyPhone',
				'cvalue' => '519-325-0111',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			6 => 
			array (
				'id' => 7,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'companyFax',
				'cvalue' => '519-973-6222',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			7 => 
			array (
				'id' => 8,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'companyEmail',
				'cvalue' => 'info@cartelmarketing.org',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			8 => 
			array (
				'id' => 9,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'logginLife',
				'cvalue' => '',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			9 => 
			array (
				'id' => 10,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'boardOpeningTime',
				'cvalue' => '06:00:00',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			10 => 
			array (
				'id' => 11,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'boardClosingTime',
				'cvalue' => '17:01:00',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			11 => 
			array (
				'id' => 12,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'haveBidShowTime',
				'cvalue' => '20',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			12 => 
			array (
				'id' => 13,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'bidTimer',
				'cvalue' => '600',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			13 => 
			array (
				'id' => 14,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'companyURL',
				'cvalue' => 'www.cartelmarketing.org',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			14 => 
			array (
				'id' => 15,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'taxGroupOrder',
				'cvalue' => '3',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			15 => 
			array (
				'id' => 16,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'taxGroupBrokerage',
				'cvalue' => '2',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			16 => 
			array (
				'id' => 17,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'taxGroupMiscCharge',
				'cvalue' => '3',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			17 => 
			array (
				'id' => 18,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'taxGroupBrokerage',
				'cvalue' => '2',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			18 => 
			array (
				'id' => 19,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'taxGroupMiscCharge',
				'cvalue' => '3',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			19 => 
			array (
				'id' => 20,
				'locale_id' => 1,
				'language_id' => 1,
				'cname' => 'companyProvince',
				'cvalue' => 'ON',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
