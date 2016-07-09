<?php

use \RobBrazier\Piwik\Piwik;

class SitesController extends BaseController {

    public $admin;

    public function __construct() {
        $this->admin = User::searchAdmin();
    }

    public function visualization() {
        return View::make('admin.visualization.visualization')->with('home', true);
    }

    public function history() {
        return View::make('admin.history.history')->with('home', true);
    }

    public function visitor() {
        return View::make('admin.visitor.visitor')->with('home', true);
    }

    public function password_reminder() {
        return View::make('admin.password.remind');
    }

    public function getData() {

        $config = array(
            'piwik_url' => 'http://gssam.ru/piwik',
            'site_id' => 1,
            'username' => 'piwik_admin',
            'password' => 'harut2015',
            'format' => 'json',
            'period' => 'previous7',
            'apikey' => '24bf2a2cd5e7496fe486643c55a20d2e'
        );
        $piwik = new Piwik($config);
        $data = $piwik->downloads('json');
        echo "<pre>";
        print_r($data);
        die;
        //$piwik::last_visits_parsed(2, 'json');	
    }
    
    public function deleteSiteById($id) {
        Sites::adminDeleteSiteById($id);
        return Redirect::route('user_site');
    }
    
    public function updateSiteById($id) {

        $validator = Validator::make(
                        array(
                            'name' => Input::get('name'),
                            'main_url' => Input::get('main_url')
                                ), array(
                            'name' => 'required|min:2|max:55|unique:piwik_site,name,'.$id.',idsite',
                            'main_url' => 'required|min:2|max:85|url|unique:piwik_site,main_url,'.$id.',idsite'
                                )
        );
        if ($validator->fails()) {
            return Redirect::route('user_site')->withErrors($validator)->withInput()->with('editable', $id);
        } else {
            $data = Input::all();
            unset($data["_token"]);
            $edited_site = Sites::AdminUpdateSiteById($id, $data);
            if ($edited_site) {
                return Redirect::route('user_site');
            } else {
                return Redirect::route('user_site');
            }
        }
    }
    
    public function setWeeklyData()
    {
        SiteSettings::getLastWeekData();
        return true;
    }
    public function testWeeklyData()
    {
        SiteSettings::getLastWeekData();
        return true;
    }

}
