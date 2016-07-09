<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

    $this->call('StatusTableSeeder');
    $this->call('BidTableSeeder');
    $this->call('BidRemindTableSeeder');
    $this->call('BrokerageTableSeeder');
    $this->call('CategoryTableSeeder');
    $this->call('ColourTableSeeder');
    $this->call('CompanyTableSeeder');
    $this->call('CompanyAddressTableSeeder');
    $this->call('CompanyDocTableSeeder');
    $this->call('CompanyTypeTableSeeder');
    $this->call('CountryTableSeeder');
    $this->call('LanguageTableSeeder');
    $this->call('LocaleTableSeeder');
    $this->call('MaturityTableSeeder');
    $this->call('OrderMiscChargeTableSeeder');
    $this->call('OrderPodTableSeeder');
    $this->call('OriginTableSeeder');
    $this->call('PackageTableSeeder');
    $this->call('PermGroupTableSeeder');
    $this->call('PermModuleTableSeeder');
    $this->call('ProductTableSeeder');
    $this->call('ProvinceTableSeeder');
    $this->call('QualityTableSeeder');
    $this->call('SiteContentTableSeeder');
    $this->call('TaxTableSeeder');
    $this->call('UserTableSeeder');
    $this->call('WeightTypeTableSeeder');
    $this->call('ProductTypeTableSeeder');
    $this->call('OrderTableSeeder');
    $this->call('ConfigurationTableSeeder');
    $this->call('TaxGroupTableSeeder');
    $this->call('BrokerageGroupTableSeeder');
    $this->call('ContentTableSeeder');
    $this->call('ProductImageTableSeeder');
	}
}


