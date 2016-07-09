<?php

class UserTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('user')->truncate();
        
		\DB::table('user')->insert(array (
			0 => 
			array (
				'id' => 1,
				'defaultlanguage_id' => 1,
				'company_id' => 3,
				'created_at' => '2014-10-02 00:00:00',
				'updated_at' => '2014-10-27 23:05:59',
				'name' => 'Peter B',
				'email' => 'pbechard@gmail.com',
				'email2' => '',
				'username' => 'peterb',
				'password' => '$2y$10$ypZVetBbGFCJVvh6725kfO.FVFeMSmUkbFs0xm37LD.elsJGiDjAm',
				'perm_groups' => 1,
				'status_id' => 1,
				'active' => 1,
				'pager' => NULL,
				'office_phone' => '519-555-1234',
				'cell_phone' => '519-564-1659',
				'remember_token' => 'oTSkpORJDAaDcsCf4JijHBpldm8grEPVcRq81kXU64ntT1eFnxMcIce5kyBw',
			),
			1 => 
			array (
				'id' => 2,
				'defaultlanguage_id' => 1,
				'company_id' => 3,
				'created_at' => '2014-10-02 00:00:00',
				'updated_at' => '2014-10-23 00:14:27',
				'name' => 'Gasper F',
				'email' => 'gfaraci@jevmarketing.com',
				'email2' => NULL,
				'username' => 'gasperf',
				'password' => '$2y$10$ypZVetBbGFCJVvh6725kfO.FVFeMSmUkbFs0xm37LD.elsJGiDjAm',
				'perm_groups' => 2,
				'status_id' => 1,
				'active' => 1,
				'pager' => NULL,
				'office_phone' => '519-966-3094',
				'cell_phone' => NULL,
				'remember_token' => 'b0kp4rNrJoruTSzN9MpHxwTngVuzbcQdxzkH7o6sbPuSLXKoFT1JrU0HppfV',
			),
			2 => 
			array (
				'id' => 3,
				'defaultlanguage_id' => 1,
				'company_id' => 3,
				'created_at' => '2014-10-02 00:00:00',
				'updated_at' => '2014-10-05 19:45:52',
				'name' => 'Jason K',
				'email' => 'jkreski@jevmarketing.com',
				'email2' => NULL,
				'username' => 'jasonk',
				'password' => '$2y$10$Jr8JelVg2a5dTwVERhGao.z2vBLc54hXjmHTNu1.MD47h4hTdnzei',
				'perm_groups' => 2,
				'status_id' => 1,
				'active' => 1,
				'pager' => NULL,
				'office_phone' => '519-966-3094',
				'cell_phone' => NULL,
				'remember_token' => 'qLVq1mmnQsWpB7x5XWPfwCveftjNwS0N1uXqTDhCSfZh71xR0rkXDcJDEZog',
			),
			3 => 
			array (
				'id' => 4,
				'defaultlanguage_id' => 1,
				'company_id' => 2,
				'created_at' => '2014-10-02 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
				'name' => 'Joe Moavro',
				'email' => 'acajsr@me.com',
				'email2' => NULL,
				'username' => 'joem',
				'password' => '$2y$10$6x3ANeFyWXRCVACrqrthTe6cCin8Zk99OIAQvU/fazoHA2pathK7a',
				'perm_groups' => 2,
				'status_id' => 1,
				'active' => 1,
				'pager' => NULL,
				'office_phone' => '519-325-0111',
				'cell_phone' => NULL,
				'remember_token' => NULL,
			),
		));
	}

}
