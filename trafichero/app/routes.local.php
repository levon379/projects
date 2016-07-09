<?php

$real_url = "";
$subdomain = "";
if (isset($_SERVER['HTTP_HOST'])) {
    $sub_domain = array_shift((explode(".", $_SERVER['HTTP_HOST']))); //subdomain name
    $domain = explode(".", $_SERVER['HTTP_HOST']);

    if (!empty($domain) && count($domain) > 2) {
        for ($i = 1; $i < count($domain); $i++) {
            if ($i == count($domain) - 1) {
                $real_url .= $domain[$i];
            } else {
                $real_url .= $domain[$i] . ".";
            }
        }
        Session::put('domain_name', $real_url);
        if ($domain[0] != "members" && $domain[0] != "admin") {
           Route::get('/', 'LoginController@showLogin');
        }
    }
}

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

//Route::get('/', 'LoginController@showLogin');
//Route::post('/doLogin', array('as' => 'do_login', 'uses' => 'LoginController@doLogin'));
Route::get('/', 'LoginController@showLogin');
Route::post('/doLogin', array('as' => 'do_login', 'uses' => 'LoginController@doLogin'));
Route::group(array('domain' => 'traffichero.dev'), function() {
    Route::get('/', array('as' => 'admin-login', 'uses' => 'HomeController@showWelcome'));
});

Route::group(array('domain' => "admin." . $real_url), function() {
    Route::get('/logout', array('as' => 'logout', 'uses' => 'LoginController@doLogout'));
    Route::get('dashboard', array('as' => 'admin_dashboard', 'uses' => 'AdminController@getDashboard'));
    Route::get('userslist', array('as' => 'user_index', 'uses' => 'AdminController@userlist'));
    Route::post('userdelete', array('as' => 'userdelete', 'uses' => 'AdminController@delete'));
    Route::get('sites', array('as' => 'user_site', 'uses' => 'AdminController@sitelist'));
    Route::get('password-reminder', array('as' => 'password-reminder', 'uses' => 'AdminController@resetpassword'));
    Route::get('visitor', array('as' => 'visitor', 'uses' => 'AdminController@visitor'));
    Route::get('/visualization', array('as' => 'admin_visualization', 'uses' => 'AdminController@visualization'));
    Route::get('/profile', array('as' => 'admin_profile', 'uses' => 'AdminController@profile'));
    Route::get('edit_account', array('as' => 'edit-admin-account', 'uses' => 'AdminController@editAccount'));
    Route::post('update_account', array('as' => 'update-admin-account', 'uses' => 'AdminController@updateAccount'))->where('id', '[0-9]+');
    Route::post('register-user', array('as' => 'register-user', 'uses' => 'AdminController@registerUser'));
    Route::post('update_password', array('as' => 'update-admin-account-password', 'uses' => 'AdminController@updateAccountPassword'))->where('id', '[0-9]+');
    Route::get('delete_site/{id}', array('as' => 'admin_delete_site', 'uses' => 'SitesController@deleteSiteById'))->where('id', '[0-9]+');
    Route::post('update_site/{id}', array('as' => 'admin_update_site', 'uses' => 'SitesController@updateSiteById'))->where('id', '[0-9]+');
    Route::get('delete_user/{id}', array('as' => 'admin_delete_user', 'uses' => 'AdminController@deleteUserById'))->where('id', '[0-9]+');
});

Route::group(array('domain' => "members." . $real_url), function() {
    Route::get('/logout', array('as' => 'logout', 'uses' => 'LoginController@doLogout'));
    Route::get('{id}/dashboard', array('as' => 'user_dashboard', 'uses' => 'UserController@Dashboard'))->where('id', '[0-9]+');
    Route::get('{id}/visitors', array('as' => 'visitors', 'uses' => 'UserController@visitors'));
    Route::get('{id}/visualization', array('as' => 'visualization', 'uses' => 'UserController@visualization'))->where('id', '[0-9]+');
    Route::get('{id}/history', array('as' => 'history', 'uses' => 'UserController@history'))->where('id', '[0-9]+');
    Route::get('sites', array('as' => 'sitelist', 'uses' => 'UserController@sites'));
    Route::get('/profile', array('as' => 'profile', 'uses' => 'UserController@profile'));
    Route::get('edit_account', array('as' => 'edit-account', 'uses' => 'UserController@editAccount'));
    Route::post('update_account', array('as' => 'update-account', 'uses' => 'UserController@updateAccount'))->where('id', '[0-9]+');
    Route::post('update_password', array('as' => 'update-account-password', 'uses' => 'UserController@updateAccountPassword'))->where('id', '[0-9]+');
    Route::get('delete_site/{id}', array('as' => 'user_delete_site', 'uses' => 'SiteController@deleteSiteById'))->where('id', '[0-9]+');
    Route::get('edit_site/{id}', array('as' => 'user_edit_site', 'uses' => 'SiteController@editSiteById'))->where('id', '[0-9]+');
    Route::post('update_site/{id}', array('as' => 'user_update_site', 'uses' => 'SiteController@updateSiteById'))->where('id', '[0-9]+');
    Route::post('create_site', array('as' => 'user_create_site', 'uses' => 'UserController@createSite'));
    Route::get('site-data', array('as' => 'site-data', 'uses' => 'SiteController@getData'));
    Route::any('map-data', array('as' => 'map-data', 'uses' => 'SiteController@dataForMap'));
    Route::get('site-traffic', array('as' => 'site-traffic', 'uses' => 'SiteController@getTraffic'));
});

