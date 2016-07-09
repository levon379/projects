<?php

class ContentTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('content')->truncate();
        
		\DB::table('content')->insert(array (
			0 => 
			array (
				'id' => 1,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-category-title',
				'content' => 'admin category title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-category-content',
				'content' => 'admin category content 2222',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 10:00:36',
			),
			2 => 
			array (
				'id' => 3,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-colour-title',
				'content' => 'admin colour title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			3 => 
			array (
				'id' => 4,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-colour-content',
				'content' => 'admin colour content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			4 => 
			array (
				'id' => 5,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-country-title',
				'content' => 'admin country title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			5 => 
			array (
				'id' => 6,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-country-content',
				'content' => 'admin country content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			6 => 
			array (
				'id' => 7,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-main-menu-title',
				'content' => 'admin main menu title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			7 => 
			array (
				'id' => 8,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-main-menu-content',
				'content' => 'admin main menu content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			8 => 
			array (
				'id' => 9,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-maturity-title',
				'content' => 'admin maturity title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			9 => 
			array (
				'id' => 10,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-maturity-content',
				'content' => 'admin maturity content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			10 => 
			array (
				'id' => 11,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-origin-title',
				'content' => 'admin origin title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			11 => 
			array (
				'id' => 12,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-origin-content',
				'content' => 'admin origin content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			12 => 
			array (
				'id' => 13,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-package-title',
				'content' => 'admin package title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			13 => 
			array (
				'id' => 14,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-package-content',
				'content' => 'admin package content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			14 => 
			array (
				'id' => 15,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-province-title',
				'content' => 'admin province title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			15 => 
			array (
				'id' => 16,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-province-content',
				'content' => 'admin province content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			16 => 
			array (
				'id' => 17,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-quality-title',
				'content' => 'admin quality title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			17 => 
			array (
				'id' => 18,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-quality-content',
				'content' => 'admin quality content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			18 => 
			array (
				'id' => 19,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-weight-type-title',
				'content' => 'admin weight type title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			19 => 
			array (
				'id' => 20,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-weight-type-content',
				'content' => 'admin weight type content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			20 => 
			array (
				'id' => 21,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'bid-status-title',
				'content' => 'bid status title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			21 => 
			array (
				'id' => 22,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'bid-status-content',
				'content' => 'bid status content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			22 => 
			array (
				'id' => 23,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'bid-to-buy-title',
				'content' => 'Place your Bid to Buy!',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 07:05:14',
			),
			23 => 
			array (
				'id' => 24,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'bid-to-buy-content',
				'content' => ' Below are the details of a product that a member wishes to SELL. Enter the Qty you would like to BUY, the receiving address,  your password, and then place your bid. If this is not exactly what you would like to Buy, scroll to the bottom and create a New Posting to Buy.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 08:10:41',
			),
			24 => 
			array (
				'id' => 25,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'bid-to-sell-title',
				'content' => 'Place your Bid to Sell !',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 07:09:38',
			),
			25 => 
			array (
				'id' => 26,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'bid-to-sell-content',
				'content' => ' Below are the details of a product that a member wishes to Buy. Enter the Qty you would like to Sell, the Shipping address, and then your password to place your bid. If this is not exactly what you would like to Sell, scroll to the bottom and create a New Posting to Sell.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 17:35:34',
			),
			26 => 
			array (
				'id' => 27,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'bid-to-sellbak-title',
				'content' => 'bid to sellbak title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			27 => 
			array (
				'id' => 28,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'bid-to-sellbak-content',
				'content' => 'bid to sellbak content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			28 => 
			array (
				'id' => 29,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'contact-us-title',
				'content' => 'Contact Us',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-12-03 04:17:15',
			),
			29 => 
			array (
				'id' => 30,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'contact-us-content',
				'content' => 'Your comments and suggestions are important to us. Please use the space provided below, or call us at 519-325-0111.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-12-03 04:16:24',
			),
			30 => 
			array (
				'id' => 31,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'create-edit-a-post-favorites-title',
				'content' => 'Create Edit a Favourite Posting.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 17:26:28',
			),
			31 => 
			array (
				'id' => 32,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'create-edit-a-post-favorites-content',
				'content' => 'Recreate or Edit a Favourite Posting. Sort by heading to help you locate the Posting you are searching for.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 17:24:11',
			),
			32 => 
			array (
				'id' => 33,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'create-edit-a-post-past-title',
				'content' => 'Create or Edit a Past Posting.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 17:17:15',
			),
			33 => 
			array (
				'id' => 34,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'create-edit-a-post-past-content',
				'content' => 'Recreate or Edit a Past Posting. Sort by heading to help you locate the Posting you are searching for.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 17:20:08',
			),
			34 => 
			array (
				'id' => 35,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'create-edit-a-post-title',
				'content' => 'Create or Edit a Posting.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 06:28:59',
			),
			35 => 
			array (
				'id' => 36,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'create-edit-a-post-content',
				'content' => 'Create a new Posting to Buy or Sell. Or, Edit an Active, Favorite or Past Posting.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 06:09:03',
			),
			36 => 
			array (
				'id' => 37,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'email-testing-title',
				'content' => 'email testing title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			37 => 
			array (
				'id' => 38,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'email-testing-content',
				'content' => 'email testing content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			38 => 
			array (
				'id' => 39,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'hello-title',
				'content' => 'hello title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			39 => 
			array (
				'id' => 40,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'hello-content',
				'content' => 'hello content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			40 => 
			array (
				'id' => 41,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'index-title',
				'content' => 'Visitor?',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			41 => 
			array (
				'id' => 42,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'index-content',
				'content' => 'Tell us about a bit about yourself and your Company. We will respond to all legitimate inquiries.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			42 => 
			array (
				'id' => 43,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'login-title',
				'content' => 'login title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			43 => 
			array (
				'id' => 44,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'login-content',
				'content' => 'login content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			44 => 
			array (
				'id' => 45,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'post-to-buy-details-title',
				'content' => 'post to buy details title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			45 => 
			array (
				'id' => 46,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'post-to-buy-details-content',
				'content' => 'post to buy details content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			46 => 
			array (
				'id' => 47,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'post-to-buy-preview-title',
				'content' => 'Post to Buy Preview',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 16:11:41',
			),
			47 => 
			array (
				'id' => 48,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'post-to-buy-preview-content',
				'content' => ' Review your Posting to Buy then choose CREATE POST or EDIT PRODUCT DETAILS',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 16:10:59',
			),
			48 => 
			array (
				'id' => 49,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'post-to-buy-title',
				'content' => 'Post To Buy',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 05:49:03',
			),
			49 => 
			array (
				'id' => 50,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'post-to-buy-content',
				'content' => 'Please enter or modify the details of a product you wish to buy.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 05:51:38',
			),
			50 => 
			array (
				'id' => 51,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'post-to-sell-details-title',
				'content' => 'post to sell details title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			51 => 
			array (
				'id' => 52,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'post-to-sell-details-content',
				'content' => 'post to sell details content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			52 => 
			array (
				'id' => 53,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'post-to-sell-preview-title',
				'content' => 'Post to Sell Preview ',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 06:43:58',
			),
			53 => 
			array (
				'id' => 54,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'post-to-sell-preview-content',
				'content' => 'Review your Posting to Sell, then click CREATE POST to display on the Board or, EDIT PRODUCT DETAILS  to make changes.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 06:49:55',
			),
			54 => 
			array (
				'id' => 55,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'post-to-sell-title',
				'content' => 'Post to Sell',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 06:32:19',
			),
			55 => 
			array (
				'id' => 56,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'post-to-sell-content',
				'content' => 'Please enter or modify the details of the product you wish to Sell below.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 06:31:52',
			),
			56 => 
			array (
				'id' => 57,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'signup-title',
				'content' => 'signup title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			57 => 
			array (
				'id' => 58,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'signup-content',
				'content' => 'signup content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			58 => 
			array (
				'id' => 59,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'status-title',
				'content' => 'status title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			59 => 
			array (
				'id' => 60,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'status-content',
				'content' => 'status content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			60 => 
			array (
				'id' => 61,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'terms-of-use-title',
				'content' => 'terms of use title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			61 => 
			array (
				'id' => 62,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'terms-of-use-content',
				'content' => 'terms of use content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			62 => 
			array (
				'id' => 63,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'view-a-bid_xxxxxxxx-title',
				'content' => 'view a bid_xxxxxxxx title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			63 => 
			array (
				'id' => 64,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'view-a-bid_xxxxxxxx-content',
				'content' => 'view a bid_xxxxxxxx content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			64 => 
			array (
				'id' => 65,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'view-bid-to-buy-title',
				'content' => 'YOU HAVE A BID !!!',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-12-02 18:03:47',
			),
			65 => 
			array (
				'id' => 66,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'view-bid-to-buy-content',
				'content' => 'You have an offer on your POST TO SELL.
Choose ACCEPT to SELL this product.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-12-02 17:59:50',
			),
			66 => 
			array (
				'id' => 67,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'view-bid-to-sell-title',
				'content' => 'YOU HAVE A BID !!!!',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-12-02 18:03:20',
			),
			67 => 
			array (
				'id' => 68,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'view-bid-to-sell-content',
				'content' => 'You have an offer on your POST TO BUY.
Choose ACCEPT to BUY this product.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-12-02 17:58:18',
			),
			68 => 
			array (
				'id' => 69,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'view-the-board-closed-title',
				'content' => 'view the board closed title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			69 => 
			array (
				'id' => 70,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'view-the-board-closed-content',
				'content' => 'view the board closed content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			70 => 
			array (
				'id' => 71,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'view-the-board-title',
				'content' => 'View the Board & Place a Bid',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 06:56:37',
			),
			71 => 
			array (
				'id' => 72,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'view-the-board-content',
				'content' => 'For more detail, click on any Item to Buy or Sell below. Use the Icons on the side to fast track to the Type of Product you are interested in.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 07:02:24',
			),
			72 => 
			array (
				'id' => 73,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-content-title',
				'content' => 'admin content title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			73 => 
			array (
				'id' => 74,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-content-content',
				'content' => 'admin content content\'s are funny even when they are "funny" like funny.',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 01:41:14',
			),
			74 => 
			array (
				'id' => 75,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-category-title',
				'content' => 'admin category title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			75 => 
			array (
				'id' => 76,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-category-content',
				'content' => 'admin category content asd f',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '2014-11-29 11:54:35',
			),
			76 => 
			array (
				'id' => 77,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-colour-title',
				'content' => 'admin colour title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			77 => 
			array (
				'id' => 78,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-colour-content',
				'content' => 'admin colour content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			78 => 
			array (
				'id' => 79,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-country-title',
				'content' => 'admin country title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			79 => 
			array (
				'id' => 80,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-country-content',
				'content' => 'admin country content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			80 => 
			array (
				'id' => 81,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-main-menu-title',
				'content' => 'admin main menu title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			81 => 
			array (
				'id' => 82,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-main-menu-content',
				'content' => 'admin main menu content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			82 => 
			array (
				'id' => 83,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-maturity-title',
				'content' => 'admin maturity title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			83 => 
			array (
				'id' => 84,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-maturity-content',
				'content' => 'admin maturity content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			84 => 
			array (
				'id' => 85,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-origin-title',
				'content' => 'admin origin title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			85 => 
			array (
				'id' => 86,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-origin-content',
				'content' => 'admin origin content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			86 => 
			array (
				'id' => 87,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-package-title',
				'content' => 'admin package title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			87 => 
			array (
				'id' => 88,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-package-content',
				'content' => 'admin package content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			88 => 
			array (
				'id' => 89,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-province-title',
				'content' => 'admin province title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			89 => 
			array (
				'id' => 90,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-province-content',
				'content' => 'admin province content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			90 => 
			array (
				'id' => 91,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-quality-title',
				'content' => 'admin quality title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			91 => 
			array (
				'id' => 92,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-quality-content',
				'content' => 'admin quality content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			92 => 
			array (
				'id' => 93,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-weight-type-title',
				'content' => 'admin weight type title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			93 => 
			array (
				'id' => 94,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-weight-type-content',
				'content' => 'admin weight type content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			94 => 
			array (
				'id' => 95,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'bid-status-title',
				'content' => 'bid status title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			95 => 
			array (
				'id' => 96,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'bid-status-content',
				'content' => 'bid status content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			96 => 
			array (
				'id' => 97,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'bid-to-buy-title',
				'content' => 'bid to buy title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			97 => 
			array (
				'id' => 98,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'bid-to-buy-content',
				'content' => 'bid to buy content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			98 => 
			array (
				'id' => 99,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'bid-to-sell-title',
				'content' => 'bid to sell title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			99 => 
			array (
				'id' => 100,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'bid-to-sell-content',
				'content' => 'bid to sell content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			100 => 
			array (
				'id' => 101,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'bid-to-sellbak-title',
				'content' => 'bid to sellbak title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			101 => 
			array (
				'id' => 102,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'bid-to-sellbak-content',
				'content' => 'bid to sellbak content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			102 => 
			array (
				'id' => 103,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'contact-us-title',
				'content' => 'contact us title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			103 => 
			array (
				'id' => 104,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'contact-us-content',
				'content' => 'contact us content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			104 => 
			array (
				'id' => 105,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'create-edit-a-post-favorites-title',
				'content' => 'create edit a post favorites title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			105 => 
			array (
				'id' => 106,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'create-edit-a-post-favorites-content',
				'content' => 'create edit a post favorites content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			106 => 
			array (
				'id' => 107,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'create-edit-a-post-past-title',
				'content' => 'create edit a post past title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			107 => 
			array (
				'id' => 108,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'create-edit-a-post-past-content',
				'content' => 'create edit a post past content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			108 => 
			array (
				'id' => 109,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'create-edit-a-post-title',
				'content' => 'create edit a post title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			109 => 
			array (
				'id' => 110,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'create-edit-a-post-content',
				'content' => 'create edit a post content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			110 => 
			array (
				'id' => 111,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'email-testing-title',
				'content' => 'email testing title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			111 => 
			array (
				'id' => 112,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'email-testing-content',
				'content' => 'email testing content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			112 => 
			array (
				'id' => 113,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'hello-title',
				'content' => 'hello title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			113 => 
			array (
				'id' => 114,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'hello-content',
				'content' => 'hello content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			114 => 
			array (
				'id' => 115,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'index-title',
				'content' => 'index title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			115 => 
			array (
				'id' => 116,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'index-content',
				'content' => 'index content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			116 => 
			array (
				'id' => 117,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'login-title',
				'content' => 'login title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			117 => 
			array (
				'id' => 118,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'login-content',
				'content' => 'login content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			118 => 
			array (
				'id' => 119,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'post-to-buy-details-title',
				'content' => 'post to buy details title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			119 => 
			array (
				'id' => 120,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'post-to-buy-details-content',
				'content' => 'post to buy details content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			120 => 
			array (
				'id' => 121,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'post-to-buy-preview-title',
				'content' => 'post to buy preview title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			121 => 
			array (
				'id' => 122,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'post-to-buy-preview-content',
				'content' => 'post to buy preview content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			122 => 
			array (
				'id' => 123,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'post-to-buy-title',
				'content' => 'post to buy title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			123 => 
			array (
				'id' => 124,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'post-to-buy-content',
				'content' => 'post to buy content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			124 => 
			array (
				'id' => 125,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'post-to-sell-details-title',
				'content' => 'post to sell details title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			125 => 
			array (
				'id' => 126,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'post-to-sell-details-content',
				'content' => 'post to sell details content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			126 => 
			array (
				'id' => 127,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'post-to-sell-preview-title',
				'content' => 'post to sell preview title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			127 => 
			array (
				'id' => 128,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'post-to-sell-preview-content',
				'content' => 'post to sell preview content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			128 => 
			array (
				'id' => 129,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'post-to-sell-title',
				'content' => 'post to sell title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			129 => 
			array (
				'id' => 130,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'post-to-sell-content',
				'content' => 'post to sell content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			130 => 
			array (
				'id' => 131,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'signup-title',
				'content' => 'signup title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			131 => 
			array (
				'id' => 132,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'signup-content',
				'content' => 'signup content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			132 => 
			array (
				'id' => 133,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'status-title',
				'content' => 'status title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			133 => 
			array (
				'id' => 134,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'status-content',
				'content' => 'status content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			134 => 
			array (
				'id' => 135,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'terms-of-use-title',
				'content' => 'terms of use title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			135 => 
			array (
				'id' => 136,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'terms-of-use-content',
				'content' => 'terms of use content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			136 => 
			array (
				'id' => 137,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'view-a-bid_xxxxxxxx-title',
				'content' => 'view a bid_xxxxxxxx title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			137 => 
			array (
				'id' => 138,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'view-a-bid_xxxxxxxx-content',
				'content' => 'view a bid_xxxxxxxx content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			138 => 
			array (
				'id' => 139,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'view-bid-to-buy-title',
				'content' => 'view bid to buy title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			139 => 
			array (
				'id' => 140,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'view-bid-to-buy-content',
				'content' => 'view bid to buy content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			140 => 
			array (
				'id' => 141,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'view-bid-to-sell-title',
				'content' => 'view bid to sell title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			141 => 
			array (
				'id' => 142,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'view-bid-to-sell-content',
				'content' => 'view bid to sell content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			142 => 
			array (
				'id' => 143,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'view-the-board-closed-title',
				'content' => 'view the board closed title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			143 => 
			array (
				'id' => 144,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'view-the-board-closed-content',
				'content' => 'view the board closed content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			144 => 
			array (
				'id' => 145,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'view-the-board-title',
				'content' => 'view the board title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			145 => 
			array (
				'id' => 146,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'view-the-board-content',
				'content' => 'view the board content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			146 => 
			array (
				'id' => 147,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-content-title',
				'content' => 'admin content title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			147 => 
			array (
				'id' => 148,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-content-content',
				'content' => 'admin content content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-11-28 21:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			148 => 
			array (
				'id' => 149,
				'locale_id' => 1,
				'language_id' => 1,
				'name' => 'terms_of_use_Content',
				'content' => ' <p>
<strong>The following TERMS OF USE are in no particular order and are equally important.</strong>
</p>

<ol>

<li>
<strong>CRITERIA FOR ELIGIBILITY TO VIEW AND USE THE BOARD.  You must have a marketing Licence issued by the OGVG.</strong>

<ul>
<li>You must be a member of the OGMA.</li>

<li>You must be a GROWER / SHIPPER with >50% of total production sold outside of the local area.</li>

<li>You must maintain a minimum monthly / annual participation.</li>
</ul>
</li>

<li>
<strong>LEGITIMATE POSTINGS ONLY</strong>

<ul>
<li>Postings must reflect current market conditions or will be removed from the Board.</li>
</ul>
</li>

<li>
<strong>KISS and DON`T TELL</strong>

<ul>
<li>Self-explanatory.</li>
</ul>
</li>

<li>
<strong>MIN MONTHLY FEES</strong>

<ul>
<li>No fees with a minimum of four successful trades ($600 Brokerage Dollars) per month on an annual average.</li>

<li>Or $300/month if not actively trading.</li>
</ul>
</li>

<li>
<strong>TRUCKING & MICS SERVICES</strong>

<ul>
<li>10% of gross revenue from TRUCKING or any other service provided by CARTEL MARKETING will be accredited to your Minimum Monthly & Annual account Trucking available @ $75/Pick & $75/Drop.</li>
</ul>
</li>

<li>
<strong>BROKERAGE/DELIVERY FEES</strong>

<ul>
<li>$.30/pkg</li>

<li>$150.00 / trade Minimum</li>

<li>Not less than 3.0 % of total value</li>
</ul>
</li>

<li>
<strong>FINAL SALE</strong>

<ul>
<li>All sales are final once shipment has been inspected and received.</li>
</ul>
</li>

<li>
<strong>FIRST IN â€¦ FIRST OUT</strong>

<ul>
<li>Cartel delivery and or pick ups get priority over all other shipments.</li>
</ul>
</li>

<li>
<strong>ASKING PRICE BID DECLINE / SHORT OR NOT SHIPPED</strong>

<ul>
<li>24 hr grace period or pay the TOTAL (BUY / SELL) brokerage.</li>
</ul>
</li>

<li>
<strong>(3Rs) RETURNS ... REJECTIONS & REGRADES</strong>

<ul>
<li>A $75 REDELIVERY FEE will be charged to the Vendor on product rejected & returned for poor quality or grade.</li>
</ul>
</li>

<li>
<strong>PAYMENT TERMS</strong>

<ul>
<li>Week ending Saturday due the following Friday.</li>
</ul>
</li>

<li>
<strong>FAILURE TO COMPLY</strong>

<ul>
<li>I understand and agree to all of the TERMS OF USE listed above.</li>

<li>I am also aware that failure to comply with any of the above listed TERMS OF USE could result in additional fees, and or the suspension of use of the BOARD.</li>
</ul>
</li>

</ol>',
				'type' => 'text',
				'content_group' => 'terms',
				'created_at' => '2014-12-04 21:00:00',
				'updated_at' => '2014-12-04 21:28:44',
			),
			149 => 
			array (
				'id' => 150,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-company-title',
				'content' => 'Admin company content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-06 10:34:26',
				'updated_at' => '2014-12-06 10:34:26',
			),
			150 => 
			array (
				'id' => 151,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-company-content',
				'content' => 'admin company content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-06 10:35:05',
				'updated_at' => '2014-12-06 10:35:05',
			),
			151 => 
			array (
				'id' => 152,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-user-title',
				'content' => 'title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-06 10:35:05',
				'updated_at' => '2014-12-06 10:35:05',
			),
			152 => 
			array (
				'id' => 153,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-user-content',
				'content' => 'text',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-06 10:35:05',
				'updated_at' => '2014-12-06 10:35:05',
			),
			153 => 
			array (
				'id' => 154,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-company-address-title',
				'content' => 'title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-07 18:30:00',
				'updated_at' => '2014-12-07 18:30:00',
			),
			154 => 
			array (
				'id' => 155,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-company-address-content',
				'content' => 'content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-07 18:30:00',
				'updated_at' => '2014-12-07 18:30:00',
			),
			155 => 
			array (
				'id' => 156,
				'locale_id' => 1,
				'language_id' => 2,
				'name' => 'terms_of_use_Content',
				'content' => ' La Terms and Conditions en Francais!',
				'type' => 'text',
				'content_group' => 'terms',
				'created_at' => '2014-12-04 21:00:00',
				'updated_at' => '2014-12-04 21:28:44',
			),
			156 => 
			array (
				'id' => 157,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-company-title',
				'content' => 'Admin company content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-06 10:34:26',
				'updated_at' => '2014-12-06 10:34:26',
			),
			157 => 
			array (
				'id' => 158,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-company-content',
				'content' => 'admin company content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-06 10:35:05',
				'updated_at' => '2014-12-06 10:35:05',
			),
			158 => 
			array (
				'id' => 159,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-user-title',
				'content' => 'title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-06 10:35:05',
				'updated_at' => '2014-12-06 10:35:05',
			),
			159 => 
			array (
				'id' => 160,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-user-content',
				'content' => 'text',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-06 10:35:05',
				'updated_at' => '2014-12-06 10:35:05',
			),
			160 => 
			array (
				'id' => 161,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-company-address-title',
				'content' => 'title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-07 18:30:00',
				'updated_at' => '2014-12-07 18:30:00',
			),
			161 => 
			array (
				'id' => 162,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-company-address-content',
				'content' => 'content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-07 18:30:00',
				'updated_at' => '2014-12-07 18:30:00',
			),
			162 => 
			array (
				'id' => 163,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-permission-title',
				'content' => 'title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-07 18:30:00',
				'updated_at' => '2014-12-07 18:30:00',
			),
			163 => 
			array (
				'id' => 164,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-permission-content',
				'content' => 'content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-07 18:30:00',
				'updated_at' => '2014-12-07 18:30:00',
			),
			164 => 
			array (
				'id' => 165,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-permission-title',
				'content' => 'title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-07 18:30:00',
				'updated_at' => '2014-12-07 18:30:00',
			),
			165 => 
			array (
				'id' => 166,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-permission-content',
				'content' => 'content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-07 18:30:00',
				'updated_at' => '2014-12-07 18:30:00',
			),
			166 => 
			array (
				'id' => 167,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-reports-recent-bids-title',
				'content' => 'title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-12 11:30:00',
				'updated_at' => '2014-12-12 11:30:00',
			),
			167 => 
			array (
				'id' => 168,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-reports-recent-bids-content',
				'content' => 'content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-12 11:30:00',
				'updated_at' => '2014-12-12 11:30:00',
			),
			168 => 
			array (
				'id' => 169,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-reports-recent-bids-title',
				'content' => 'title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-12 11:30:00',
				'updated_at' => '2014-12-12 11:30:00',
			),
			169 => 
			array (
				'id' => 170,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-reports-recent-bids-content',
				'content' => 'content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-12 11:30:00',
				'updated_at' => '2014-12-12 11:30:00',
			),
			170 => 
			array (
				'id' => 171,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-reports-customer-history-title',
				'content' => 'title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-13 19:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			171 => 
			array (
				'id' => 172,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-reports-customer-history-content',
				'content' => 'content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-13 19:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			172 => 
			array (
				'id' => 173,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-reports-customer-history-title',
				'content' => 'french title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-13 19:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			173 => 
			array (
				'id' => 174,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-reports-customer-history-content',
				'content' => 'french content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-13 19:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			174 => 
			array (
				'id' => 175,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-reports-completed-transactions-title',
				'content' => 'title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-13 19:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			175 => 
			array (
				'id' => 176,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-reports-completed-transactions-content',
				'content' => 'content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-13 19:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			176 => 
			array (
				'id' => 177,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-reports-completed-transactions-title',
				'content' => 'french title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-13 19:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			177 => 
			array (
				'id' => 178,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-reports-completed-transactions-content',
				'content' => 'french content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-13 19:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			178 => 
			array (
				'id' => 179,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-order-title',
				'content' => 'title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-13 19:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			179 => 
			array (
				'id' => 180,
				'locale_id' => 0,
				'language_id' => 1,
				'name' => 'admin-order-content',
				'content' => 'content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-13 19:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			180 => 
			array (
				'id' => 181,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-order-title',
				'content' => 'french title',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-13 19:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			181 => 
			array (
				'id' => 182,
				'locale_id' => 0,
				'language_id' => 2,
				'name' => 'admin-order-content',
				'content' => 'french content',
				'type' => 'text',
				'content_group' => 'help',
				'created_at' => '2014-12-13 19:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
