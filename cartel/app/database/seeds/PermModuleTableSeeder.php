<?php

class PermModuleTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('perm_module')->truncate();
        
		\DB::table('perm_module')->insert(array (
			0 => 
			array (
				'id' => 1,
				'lookupname' => 'AllowSuperUser',
				'showname' => 'Show/Allow all SuperUser features',
				'sort_group' => 'super',
				'created_at' => '2014-10-10 04:00:00',
				'updated_at' => '2014-10-10 04:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'lookupname' => 'ViewSiteNav',
				'showname' => 'Show site navigation',
				'sort_group' => 'site',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			2 => 
			array (
				'id' => 4,
				'lookupname' => 'Login',
				'showname' => 'Allow Login to site',
				'sort_group' => 'site',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			3 => 
			array (
				'id' => 8,
				'lookupname' => 'ViewTheBoard',
				'showname' => 'Allow to view the Board',
				'sort_group' => 'site',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			4 => 
			array (
				'id' => 16,
				'lookupname' => 'CreateAPost',
			'showname' => 'Allow to create posts (buy/sell)',
				'sort_group' => 'site',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			5 => 
			array (
				'id' => 32,
				'lookupname' => 'SubmitABid',
			'showname' => 'Allow to submit a bid (buy/sell)',
				'sort_group' => 'site',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			6 => 
			array (
				'id' => 64,
				'lookupname' => 'ViewABid',
			'showname' => 'Allow to view a bid (buy/sell)',
				'sort_group' => 'site',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			7 => 
			array (
				'id' => 128,
				'lookupname' => 'RespondToABid',
			'showname' => 'Allow to respond to a bid  (buy/sell)',
				'sort_group' => 'site',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			8 => 
			array (
				'id' => 256,
				'lookupname' => 'ViewBoardExtraInfo',
				'showname' => 'Show extra details on board',
				'sort_group' => 'site',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			9 => 
			array (
				'id' => 512,
				'lookupname' => 'ExtraFeatureViewPoster',
				'showname' => 'Allow extra features',
				'sort_group' => 'site',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			10 => 
			array (
				'id' => 1024,
				'lookupname' => 'CreateAPost_SellOnly',
			'showname' => 'Allow to submit a bid (sell only)',
				'sort_group' => 'site',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			11 => 
			array (
				'id' => 2048,
				'lookupname' => 'SubmitABid_SellOnly',
			'showname' => 'Allow to view a bid (sell only)',
				'sort_group' => 'site',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			12 => 
			array (
				'id' => 4096,
				'lookupname' => 'ViewABid_SellOnly',
			'showname' => 'Allow to respond to a bid (sell only)',
				'sort_group' => 'site',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			13 => 
			array (
				'id' => 8192,
				'lookupname' => 'RespondToABid_SellOnly',
			'showname' => 'Allow to create a post (sell only)',
				'sort_group' => 'site',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			14 => 
			array (
				'id' => 262144,
				'lookupname' => 'ViewDailyOperations',
				'showname' => 'Admin - Allow view daily ops reports',
				'sort_group' => 'admin',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			15 => 
			array (
				'id' => 524288,
				'lookupname' => 'ViewReports',
				'showname' => 'Admin - Allow view reports',
				'sort_group' => 'admin',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			16 => 
			array (
				'id' => 1048576,
				'lookupname' => 'EditCompanies',
				'showname' => 'Admin - Allow edit Companies',
				'sort_group' => 'admin',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			17 => 
			array (
				'id' => 2097152,
				'lookupname' => 'EditCompanyAddresses',
				'showname' => 'Admin - Allow edit Company Address',
				'sort_group' => 'admin',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			18 => 
			array (
				'id' => 4194304,
				'lookupname' => 'EditUsers',
				'showname' => 'Admin - Allow edit Users',
				'sort_group' => 'admin',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			19 => 
			array (
				'id' => 8388608,
				'lookupname' => 'EditCompanyTypes',
				'showname' => 'Admin - Allow edit Company Types',
				'sort_group' => 'admin',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			20 => 
			array (
				'id' => 16777216,
				'lookupname' => 'EditProductDetails',
				'showname' => 'Admin - Allow edit Product Details',
				'sort_group' => 'admin',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			21 => 
			array (
				'id' => 33554432,
				'lookupname' => 'UseMessagingSystem',
				'showname' => 'Admin - Allow to use Messaging System',
				'sort_group' => 'admin',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			22 => 
			array (
				'id' => 67108864,
				'lookupname' => 'EditGeneralConfig',
				'showname' => 'Admin - Allow edit General Config',
				'sort_group' => 'admin',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			23 => 
			array (
				'id' => 134217728,
				'lookupname' => 'EditSiteContent',
				'showname' => 'Admin - Allow edit Site Content',
				'sort_group' => 'admin',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			24 => 
			array (
				'id' => 268435456,
				'lookupname' => 'EditHelpContent',
				'showname' => 'Admin - Allow edit Help Content',
				'sort_group' => 'admin',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
			25 => 
			array (
				'id' => 536870912,
				'lookupname' => 'EditBrokerageFees',
				'showname' => 'Admin - Allow edit Brokerage Fees',
				'sort_group' => 'admin',
				'created_at' => '2014-12-08 18:00:00',
				'updated_at' => '2014-12-08 18:00:00',
			),
		));
	}

}
