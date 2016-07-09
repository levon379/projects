<?php

class Sites extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'piwik_site';

    public static function listAllSites() {
        return DB::table('piwik_site')
                        ->leftJoin('piwik_user', 'piwik_site.user_id', '=', 'piwik_user.id')
                        ->select('piwik_site.*', 'piwik_user.first_name', 'piwik_user.last_name')
                        ->get();
    }

    public static function listUserSites() {
        return DB::table('piwik_site')->where('user_id', Auth::user()->id)->get();
    }

    public static function getSiteById($site_id) {
        return DB::table('piwik_site')
                        ->where('user_id', Auth::user()->id)
                        ->where('idsite', $site_id)
                        ->get();
    }

    public static function getUserFirstSite() {
        $firts_site =  DB::table('piwik_site')
                        ->where('user_id', Auth::user()->id)
                        ->orderBy('idsite', 'asc')
                        ->take(1)
                        ->get();
        if(count($firts_site)>0)
        {
             return $firts_site[0];
        }
        return $firts_site;
       
    }

    public static function deleteSiteById($id) {
        return DB::table('piwik_site')
                        ->where('idsite', $id)
                        ->where('user_id', Auth::user()->id)
                        ->delete();
    }

    public static function adminDeleteSiteById($id) {
        return DB::table('piwik_site')
                        ->where('idsite', $id)
                        ->delete();
    }

    public static function updateSiteById($id, $data) {
        return DB::table('piwik_site')
                        ->where('idsite', $id)
                        ->where('user_id', Auth::user()->id)
                        ->update($data);
    }

    public static function AdminUpdateSiteById($id, $data) {
        return DB::table('piwik_site')
                        ->where('idsite', $id)
                        ->update($data);
    }

    public static function createSite($data) {
        return DB::table('piwik_site')
                        ->insertGetId($data);
    }

    public static function getLastMonthData($site_id) {
        return DB::table('rpt_visits_srv_time')
                        ->where('site_id', $site_id)
                        ->get();
    }
    
    public static function getLastDayVisitsCount($site_id) {
        
        $last_day_date = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
        $last_day_date = date('Y-m-d', $last_day_date);
        return DB::table('rpt_daily_visitors_count')
                        ->where('site_id', $site_id)
                        ->where('date', $last_day_date)
                        ->sum('visits_count');
    }
    
    public static function getLastWeekVisitsCount($site_id) {
        
        $last_week_date = mktime(0, 0, 0, date("m"), date("d") - 7, date("Y"));
        $last_week_date = date('Y-m-d', $last_week_date);
        return DB::table('rpt_daily_visitors_count')
                        ->where('site_id', $site_id)
                        ->where('date', '>=', $last_week_date)
                        ->sum('visits_count');
    }
    
    public static function getLastMonthVisitsCount($site_id) {
        
        $last_month_date = mktime(0, 0, 0, date("m"), date("d") - 30, date("Y"));
        $last_month_date = date('Y-m-d', $last_month_date);
        return DB::table('rpt_daily_visitors_count')
                        ->where('site_id', $site_id)
                        ->where('date', '>=', $last_month_date)
                        ->sum('visits_count');
    }
    
    public static function getLastThreeMonthsVisitsCount($site_id) {
        
        $last_three_months_date = mktime(0, 0, 0, date("m"), date("d") - 90, date("Y"));
        $last_three_months_date = date('Y-m-d', $last_three_months_date);
//        echo $last_three_months_date;die;
        return DB::table('rpt_daily_visitors_count')
                        ->where('site_id', $site_id)
                        ->where('date', '>=', $last_three_months_date)
                        ->sum('visits_count');
    }

}
