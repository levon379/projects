<?php

class TaxTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('tax')->truncate();
        
		\DB::table('tax')->insert(array (
			0 => 
			array (
				'id' => 1,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'GST',
				'rate' => '7.00',
				'start_date' => '1950-01-01 00:00:00',
				'end_date' => '2006-06-30 23:59:59',
				'tax_group_id' => 2,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'GST',
				'rate' => '6.00',
				'start_date' => '2006-07-01 00:00:00',
				'end_date' => '2007-12-31 23:59:59',
				'tax_group_id' => 2,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			2 => 
			array (
				'id' => 3,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'GST',
				'rate' => '5.00',
				'start_date' => '2008-01-01 00:00:00',
				'end_date' => '2010-06-30 23:59:59',
				'tax_group_id' => 2,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			3 => 
			array (
				'id' => 4,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'HST',
				'rate' => '13.00',
				'start_date' => '2010-07-01 00:00:00',
				'end_date' => '2099-00-01 23:59:59',
				'tax_group_id' => 2,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			4 => 
			array (
				'id' => 5,
				'locale_id' => 1,
				'language_id' => 1,
			'name' => 'GST (Quebec)',
				'rate' => '5.00',
				'start_date' => '2008-01-01 00:00:00',
				'end_date' => '2099-01-01 23:59:59',
				'tax_group_id' => 4,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			5 => 
			array (
				'id' => 6,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'GST',
				'rate' => '7.00',
				'start_date' => '1950-01-01 00:00:00',
				'end_date' => '2006-06-30 23:59:59',
				'tax_group_id' => 3,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			6 => 
			array (
				'id' => 7,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'GST',
				'rate' => '6.00',
				'start_date' => '2006-07-01 00:00:00',
				'end_date' => '2007-12-31 23:59:59',
				'tax_group_id' => 3,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			7 => 
			array (
				'id' => 8,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'GST',
				'rate' => '5.00',
				'start_date' => '2008-01-01 00:00:00',
				'end_date' => '2010-06-30 23:59:59',
				'tax_group_id' => 3,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			8 => 
			array (
				'id' => 9,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'HST',
				'rate' => '13.00',
				'start_date' => '2010-07-01 00:00:00',
				'end_date' => '2099-01-01 23:59:59',
				'tax_group_id' => 3,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			9 => 
			array (
				'id' => 10,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'No Tax',
				'rate' => '0.00',
				'start_date' => '1950-01-01 00:00:00',
				'end_date' => '2099-01-01 23:59:59',
				'tax_group_id' => 1,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
