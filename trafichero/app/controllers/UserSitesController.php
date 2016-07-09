<?php

use \RobBrazier\Piwik\Piwik;

class UserSitesController extends BaseController {

    public $admin;

    public function __construct() {
        $this->admin = User::searchAdmin();
    }

    public function deleteSiteById($id) {
        Sites::deleteSiteById($id);
        return Redirect::route('sitelist');
    }
    
    public function createSite() {
        $validator = Validator::make(
                        array(
                            'new_site_name' => Input::get('new_site_name'),
                            'new_site_main_url' => Input::get('new_site_main_url')
                                ), array(
                            'new_site_name' => 'required|min:2|max:55|unique:piwik_site,name',
                            'new_site_main_url' => 'required|min:2|max:85|url|unique:piwik_site,main_url'
                                )
        );
        if ($validator->fails()) {
            return Redirect::route('sitelist')->withErrors($validator)->withInput();
        } else {
            $data = Input::all();
            $data = array();
            $data['name'] = Input::get('new_site_name');
            $data['main_url'] = Input::get('new_site_main_url');
            $data['user_id'] = Auth::user()->id;
            unset($data["_token"]);
            $edited_site = Sites::createSite($data);
            if ($edited_site) {
                return Redirect::route('sitelist');
            } else {
                return Redirect::route('sitelist');
            }
        }
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
            return Redirect::route('sitelist')->withErrors($validator)->withInput()->with('editable', $id);
        } else {
            $data = Input::all();
            unset($data["_token"]);
            $edited_site = Sites::updateSiteById($id, $data);
            if ($edited_site) {
                return Redirect::route('sitelist');
            } else {
                return Redirect::route('sitelist');
            }
        }
    }

}
