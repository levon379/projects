<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GetWeeklyData extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'GetWeeklyData:getWeeklyData';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get visitors counts per hours from mongo for each site.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
            $all_sites = DB::table('piwik_site')
                                ->select('piwik_site.idsite')
                                ->where('cron', 0)
                                ->take(2)
                                ->get();

            $sites = array();
            $result = array();
            foreach($all_sites as $site) {
                
                $data_last_day = DB::connection('mongodb')->collection('traffic')->raw(function($collection) use ($site) {
                    $last_day = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
                    return $collection->aggregate([
                        ['$match' => [ 'srv_time' => ['$gt' => strval($last_day),'$lte' => strval($last_day + (3600 * 24))],'idsite' => strval($site->idsite)]],
                        ['$group' => ['_id' => ['idsite' => '$idsite'], 'count' => ['$sum' => 1]]],
                    ]);
                });

                if(!empty($data_last_day['result'])) {
                    $count_last_day = $data_last_day['result'][0]['count'];
                } else {
                    $count_last_day = 0;
                }

                $last_day_date = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
                $last_day_date = date('Y-m-d', $last_day_date);

                $last_day = array();
                $last_day['site_id'] = $site->idsite;
                $last_day['visits_count'] = $count_last_day;
                $last_day['date'] = $last_day_date;

                DB::table('rpt_daily_visitors_count')->insert($last_day);
                
                $data = array();
                for ($i = 0; $i < 24; $i ++) {
                    $data_per_hour = DB::connection('mongodb')->collection('traffic')->raw(function($collection) use ($site, $i) {
                        $last_day = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
                        return $collection->aggregate([
                            ['$match' => [ 'srv_time' => [ '$gt' => strval($last_day + (3600 * $i)),'$lte' => strval($last_day + (3600 * ($i + 1))) ],'idsite' => strval($site->idsite)]],
                            ['$group' => ['_id' => ['idsite' => '$idsite'], 'count' => ['$sum' => 1]]],
                        ]);
                    });
                    if(!empty($data_per_hour['result'])) {
                        $data[] = $data_per_hour['result'][0]['count'];
                    } else {
                        $data[] = 0;
                    }
                }

                $site_stats = array(
                    'h00' => $data[0],
                    'h01' => $data[1],
                    'h02' => $data[2],
                    'h03' => $data[3],
                    'h04' => $data[4],
                    'h05' => $data[5],
                    'h06' => $data[6],
                    'h07' => $data[7],
                    'h08' => $data[8],
                    'h09' => $data[9],
                    'h10' => $data[10],
                    'h11' => $data[11],
                    'h12' => $data[12],
                    'h13' => $data[13],
                    'h14' => $data[14],
                    'h15' => $data[15],
                    'h16' => $data[16],
                    'h17' => $data[17],
                    'h18' => $data[18],
                    'h19' => $data[19],
                    'h20' => $data[20],
                    'h21' => $data[21],
                    'h22' => $data[22],
                    'h23' => $data[23],
                );

                $site_lw_stats = DB::table('rpt_visits_srv_time')
                                    ->where('site_id', $site->idsite)
                                    ->get();
                if(empty($site_lw_stats)) {
                    $site_stats['site_id'] = $site->idsite;
                    $site_stats['updated'] = 1;
                    DB::table('rpt_visits_srv_time')->insert($site_stats);
                }
                else {
                    $updated = $site_lw_stats[0]->updated;
                    if($updated == 7) {
                        foreach($site_stats as $key=>$val){
                            $site_stats[$key] = ((($site_lw_stats[0]->$key) * 6) + $val) / 7;
                        }
                    }
                    elseif($updated < 7) {
                        foreach($site_stats as $key=>$val){
                            $site_stats[$key] = ((($site_lw_stats[0]->$key) * $updated) + $val) / ($updated + 1);
                        }
                        $site_stats['updated'] = $updated + 1;
                    }
                    DB::table('rpt_visits_srv_time')
                            ->where('site_id', $site->idsite)
                            ->update($site_stats);
                }
                
                $site_cron = array();
                $site_cron['cron'] = 1;
                DB::table('piwik_site')
                            ->where('idsite', $site->idsite)
                            ->update($site_cron);
            }
            
            $another_sites = DB::table('piwik_site')
                            ->select('piwik_site.idsite')
                            ->where('cron', 0)
                            ->get();
            if(!empty($another_sites)) {
                self::fire();
            } else {
                $last_three_months = mktime(0, 0, 0, date("m"), date("d") - 90, date("Y"));
                $last_three_months_date = date('Y-m-d', $last_three_months);
                $site_three_months_stats = DB::table('rpt_daily_visitors_count')
                                    ->where('date', '<', $last_three_months_date)
                                    ->delete();
                $site_cron = array();
                $site_cron['cron'] = 0;
                DB::table('piwik_site')
                            ->update($site_cron);
            }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
