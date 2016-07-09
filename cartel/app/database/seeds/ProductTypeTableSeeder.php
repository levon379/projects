<?php

class ProductTypeTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_type')->truncate();
        
		\DB::table('product_type')->insert(array (
			0 => 
			array (
				'id' => 1,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Tree Fruit',
				'image' => 'tree-fruit icon',
				'jump_link' => 'tree-fruit',
			'bgcolor' => 'rgb(150, 194, 231)',
				'tax_group_id' => 2,
				'brokerage_group_id' => 2,
				'ordernum' => 10,
				'status_id' => 32,
				'created_at' => '2014-10-16 22:00:00',
				'updated_at' => '2014-10-16 22:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Indoor Hot House',
				'image' => 'hot-house icon',
				'jump_link' => 'hot-house',
			'bgcolor' => 'rgb(255, 201, 200)',
				'tax_group_id' => 2,
				'brokerage_group_id' => 2,
				'ordernum' => 20,
				'status_id' => 32,
				'created_at' => '2014-10-16 22:00:00',
				'updated_at' => '2014-10-16 22:00:00',
			),
			2 => 
			array (
				'id' => 3,
				'locale_id' => 1,
				'language_id' => 1,
			'name' => 'Outdoor (field)',
				'image' => 'field icon',
				'jump_link' => 'field',
			'bgcolor' => 'rgb(207, 225, 136)',
				'tax_group_id' => 2,
				'brokerage_group_id' => 2,
				'ordernum' => 30,
				'status_id' => 32,
				'created_at' => '2014-10-16 22:00:00',
				'updated_at' => '2014-10-16 22:00:00',
			),
			3 => 
			array (
				'id' => 4,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Organic',
				'image' => 'organic icon',
				'jump_link' => 'organic',
			'bgcolor' => 'rgb(255, 224, 138)',
				'tax_group_id' => 2,
				'brokerage_group_id' => 2,
				'ordernum' => 40,
				'status_id' => 32,
				'created_at' => '2014-10-16 22:00:00',
				'updated_at' => '2014-10-16 22:00:00',
			),
			4 => 
			array (
				'id' => 5,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Root Veggie',
				'image' => 'root-veggie icon',
				'jump_link' => 'root-veggie',
			'bgcolor' => 'rgb(201, 154, 121)',
				'tax_group_id' => 2,
				'brokerage_group_id' => 2,
				'ordernum' => 50,
				'status_id' => 32,
				'created_at' => '2014-10-16 22:00:00',
				'updated_at' => '2014-10-16 22:00:00',
			),
			5 => 
			array (
				'id' => 6,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Misc',
				'image' => 'misc icon',
				'jump_link' => 'misc',
			'bgcolor' => 'rgb(163, 163, 163)',
				'tax_group_id' => 2,
				'brokerage_group_id' => 2,
				'ordernum' => 60,
				'status_id' => 32,
				'created_at' => '2014-10-16 22:00:00',
				'updated_at' => '2014-10-16 22:00:00',
			),
			6 => 
			array (
				'id' => 7,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'Frieght/Trucking',
				'image' => 'truck icon',
				'jump_link' => 'truck',
			'bgcolor' => 'rgb(150,194,231)',
				'tax_group_id' => 3,
				'brokerage_group_id' => 1,
				'ordernum' => 100,
				'status_id' => 74,
				'created_at' => '2014-11-15 22:25:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
