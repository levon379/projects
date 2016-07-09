<?php
class ProductImageTableSeeder extends Seeder {
	/*
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_image')->truncate();
    
		\DB::table('product_image')->insert(array (
			0 => 
			array (
				'id' => 1,
			),
      
			1 => 
			array (
				'id' => 2,
			),
		));
	}
}
