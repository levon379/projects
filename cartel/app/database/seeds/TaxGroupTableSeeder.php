<?php

class TaxGroupTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('tax_group')->truncate();
        
		\DB::table('tax_group')->insert(array (
			0 => 
			array (
				'id' => 1,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'No Taxes',
				'tax_product' => 0,
				'tax_brokerage' => 0,
				'status_id' => 69,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'locale_id' => 1,
				'language_id' => 1,
			'name' => 'Brokerage Fee Only (HST 13.0%)',
				'tax_product' => 0,
				'tax_brokerage' => 1,
				'status_id' => 69,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			2 => 
			array (
				'id' => 3,
				'locale_id' => 1,
				'language_id' => 1,
			'name' => 'Entire Order (HST 13.0%)',
				'tax_product' => 1,
				'tax_brokerage' => 1,
				'status_id' => 69,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			3 => 
			array (
				'id' => 4,
				'locale_id' => 1,
				'language_id' => 1,
			'name' => 'Entire Order (GST (Quebec) 5.0%)',
				'tax_product' => 1,
				'tax_brokerage' => 1,
				'status_id' => 69,
				'created_at' => '2014-11-09 17:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
