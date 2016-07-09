<?php

class WeightTypeTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('weight_type')->truncate();
        
		\DB::table('weight_type')->insert(array (
			0 => 
			array (
				'id' => 6,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'oz',
				'isbulk' => 0,
				'system' => 'imperial',
				'ordernum' => 1,
				'value_wrt_grams' => 28.349499999999999,
				'status_id' => 44,
				'created_at' => '2014-10-17 04:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 7,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'gr',
				'system' => 'metric',
				'isbulk' => 0,
				'ordernum' => 2,
				'value_wrt_grams' => 1,
				'status_id' => 44,
				'created_at' => '2014-10-17 04:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			2 => 
			array (
				'id' => 8,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'lb',
				'isbulk' => 0,
				'system' => 'imperial',
				'ordernum' => 3,
				'value_wrt_grams' => 453.59199999999998,
				'status_id' => 44,
				'created_at' => '2014-10-17 04:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			3 => 
			array (
				'id' => 9,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'kg',
				'system' => 'metric',
				'isbulk' => 0,
				'ordernum' => 4,
				'value_wrt_grams' => 1000,
				'status_id' => 44,
				'created_at' => '2014-10-17 04:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			4 => 
			array (
				'id' => 10,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'lb',
				'isbulk' => 1,
				'system' => 'imperial',
				'ordernum' => 1,
				'value_wrt_grams' => 453.59199999999998,
				'status_id' => 44,
				'created_at' => '2014-10-17 04:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			5 => 
			array (
				'id' => 11,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'kg',
				'system' => 'metric',
				'isbulk' => 1,
				'ordernum' => 2,
				'value_wrt_grams' => 1000,
				'status_id' => 44,
				'created_at' => '2014-10-17 04:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			6 => 
			array (
				'id' => 12,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Peter',
				'system' => 'metric',
				'isbulk' => 0,
				'ordernum' => 0,
				'value_wrt_grams' => 12.25,
				'status_id' => 46,
				'created_at' => '2014-11-05 18:49:14',
				'updated_at' => '2014-11-05 18:49:31',
			),
		));
	}

}
