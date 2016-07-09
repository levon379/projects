<?php

class UserController extends BaseController {

    public $tag;
    public $site_id;
    protected $layout = "layout.user";

    public function __construct() {
        // Closure as callback
        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return View::make('login.login');
            }
        });
    }

    public function dashboard($id) {
        $selected_site = Sites::getSiteById($id);
        $user_sites = Sites::listUserSites();
        if (!empty($selected_site)) {
            $site_name = $selected_site[0]->name;
        } elseif (!empty($user_sites)) {
            $site_name = $user_sites[0]->name;
            ;
            $id = $user_sites[0]->idsite;
        } else {
            $site_name = '';
            $id = 0;
        }
        $data = array(
            'home' => true,
            'user_sites' => $user_sites,
            'site_id' => $id,
            'site_name' => $site_name
        );
        return View::make('user.dashboard.dashboard')->with($data);
    }

    public function visualization($id) {
        $selected_site = Sites::getSiteById($id);
        $user_sites = Sites::listUserSites();
        if (!empty($selected_site)) {
            $site_name = $selected_site[0]->name;
        } elseif (!empty($user_sites)) {
            $site_name = $user_sites[0]->name;
            $id = $user_sites[0]->idsite;
        } else {
            $site_name = '';
            $id = 0;
        }

        $data = array(
            'home' => true,
            'user_sites' => $user_sites,
            'site_id' => $id,
            'site_name' => $site_name
        );
        return View::make('user.visualization.visualization')->with($data);
    }

    public function visitors($id) {
        $selected_site = Sites::getSiteById($id);
        $user_sites = Sites::listUserSites();
        if (!empty($selected_site)) {
            $site_name = $selected_site[0]->name;
        } elseif (!empty($user_sites)) {
            $site_name = $user_sites[0]->name;
            $id = $user_sites[0]->idsite;
        } else {
            $site_name = '';
            $id = 0;
        }

        $data = array(
            'home' => true,
            'user_sites' => $user_sites,
            'site_id' => $id,
            'site_name' => $site_name
        );
        return View::make('user.visitor.visitor')->with($data);
    }

    public function history($id) {
        $selected_site = Sites::getSiteById($id);
        $user_sites = Sites::listUserSites();
        if (!empty($selected_site)) {
            $site_name = $selected_site[0]->name;
        } elseif (!empty($user_sites)) {
            $site_name = $user_sites[0]->name;
            $id = $user_sites[0]->idsite;
        } else {
            $site_name = '';
            $id = 0;
        }
        
        $last_day_visits_count = Sites::getLastDayVisitsCount($id);
        $last_week_visits_count = Sites::getLastWeekVisitsCount($id);
        $last_month_visits_count = Sites::getLastMonthVisitsCount($id);
        $last_three_months_visits_count = Sites::getLastThreeMonthsVisitsCount($id);
        
        $last_month_data = Sites::getLastMonthData($id);
        
        $data = array(
            'home' => true,
            'user_sites' => $user_sites,
            'site_id' => $id,
            'site_name' => $site_name,
            'last_month_data' => $last_month_data,
            'last_day_visits_count' => $last_day_visits_count,
            'last_week_visits_count' => $last_week_visits_count,
            'last_month_visits_count' => $last_month_visits_count,
            'last_three_months_visits_count' => $last_three_months_visits_count
        );
        return View::make('user.history.history')->with($data);
    }

    public function sites() {
        $first_site = Sites::getUserFirstSite();
        if (!empty($first_site)) {
            $first_site_id = $first_site->idsite;
        } else
            $first_site_id = 0;
        $user_sites = Sites::listUserSites();
        $code = "";
        if (Session::has('code')) {
            $code = Session::get('code');
        }
        $data = array(
            'user_section' => true,
            'user_sites' => $user_sites,
            'site_id' => $first_site_id,
            'code' => $code,
//            'site_name' => $site_name
        );

        return View::make('user.site.site')
                        ->with($data);
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
            $value = Session::get('domain_name');
            $code = <<<EOT
<!-- TrafficHero -->
<script type="text/javascript">
var _paq = _paq || [];
(function(){ var u="//data.$value/js/";
_paq.push(['setTrackerUrl',u+'traffichero.php']);
_paq.push(['setSiteId', $edited_site]);
_paq.push(['trackPageView']);
_paq.push(['enableLinkTracking']);
var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; 
g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'traffichero.js'; s.parentNode.insertBefore(g,s);
 })();
</script>
<!-- End TrafficHero Code -->
EOT;
            //Session::set('code', $code);
            return Redirect::route('sitelist')->with('code', $code);
        }
    }

    public function profile() {
        $first_site = Sites::getUserFirstSite();
        if (!empty($first_site)) {
            $first_site_id = $first_site[0]->idsite;
        } else
            $first_site_id = 0;
        $user_sites = Sites::listUserSites();
        $data = array(
            'home' => true,
            'user_sites' => $user_sites,
            'site_id' => $first_site_id,
//            'site_name' => $site_name
        );
        return View::make('user.profile.profile')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function editAccount() {
        $first_site = Sites::getUserFirstSite();
        if (!empty($first_site)) {
            $first_site_id = $first_site[0]->idsite;
        } else
            $first_site_id = 0;
        $user_sites = Sites::listUserSites();
        $data = array(
            'home' => true,
            'user_sites' => $user_sites,
            'site_id' => $first_site_id
        );
        return View::make('user.profile.edit_account')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateAccount() {

        Validator::extend('password_true', function($field, $value, $parameters) {
            if (Hash::check(Input::get('correct_password'), Auth::user()->password)) {
                return true;
            }
        });

        $validator = Validator::make(
                        array(
                    'login' => Input::get('login'),
                    'first_name' => Input::get('first_name'),
                    'last_name' => Input::get('last_name'),
                    'email' => Input::get('email'),
                    'correct_password' => Input::get('correct_password')
                        ), array(
                    'login' => 'required|alpha_num|min:2|max:25',
                    'first_name' => 'required|alpha_num|min:2|max:35',
                    'last_name' => 'required|alpha_num|min:2|max:35',
                    'email' => 'required|email',
                    'correct_password' => 'required|password_true'
                        ), array(
                    'password_true' => 'Please enter correct password!'
                        )
        );

        if ($validator->fails()) {
            return Redirect::route('edit-account', Auth::user()->id)->withErrors($validator)->withInput();
        } else {
            $data = Input::except('correct_password');
            unset($data["_token"]);
            $changeAccount = User::changeAccountSettings($data);
            if ($changeAccount) {
                return Redirect::route('profile')->with('message', 'Your account successfully updated.');
            } else {
                return Redirect::route('profile')->with('error_mes', 'ERROR! Please try again later.');
            }
        }
    }

    public function updateAccountPassword() {

        Validator::extend('old_password_true', function($field, $value, $parameters) {
            if (Hash::check(Input::get('old_password'), Auth::user()->password)) {
                return true;
            }
        });

        $validator = Validator::make(
                        array(
                    'new_password' => Input::get('new_password'),
                    'new_password_confirmation' => Input::get('new_password_confirmation'),
                    'old_password' => Input::get('old_password')
                        ), array(
                    'new_password' => 'required|alpha_num|between:6,12',
                    'new_password_confirmation' => 'required|same:new_password',
                    'old_password' => 'required|old_password_true|alpha_num|between:6,12'
                        ), array(
                    'old_password_true' => 'Please enter correct old password!'
                        )
        );

        if ($validator->fails()) {
            return Redirect::route('edit-account', Auth::user()->id)->withErrors($validator)->withInput()->with('change', 'change_pass');
        } else {
            $data['password'] = Hash::make(Input::get('new_password'));
            $changeAccount = User::changeAccountSettings($data);
            if ($changeAccount) {
                return Redirect::route('profile')->with('message', 'Your password updated successfully.');
            } else {
                return Redirect::route('profile')->with('error', 'ERROR! Please try again later.');
            }
        }
    }

    public function reset_password() {

        $data = Input::all();
        $rules = array(
            'password' => 'required|min:3|confirmed',
            'password_confirmation' => 'required|min:3'
        );

        // Create a new validator instance.
        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
            $new_password = Hash::make(Input::get('password'));
            $data = array('newpassword' => $new_password, 'user_id' => $data['user_id']);
            $user = User::creatNewPassword($data);
            $user_data = User::getUserEmail($data['user_id']);
            if ($user) {
                $viewData = array(); // Data to pass to emails/pdf views
                if (Config::get('mail.pretend')) {
                    $pretendView = "";
                    $pretendView .= '<br /><br />EMAILS:<br />';
                    $pretendView .= View::make('emails.user-changepassword');

                    echo $pretendView;
                    return true;
                }

                /* ------------------------------------------------------------- */
                /* Email PO to seller */
                /* ------------------------------------------------------------- */
                $toEmail = array('email' => $user_data->email,
                    'name' => $user_data->first_name . " " . $user_data->last_name);
                $fromEmail = array('email' => 'vardan.meloyan92@gmail.com',
                    'name' => 'Your Name');
                $subject = "Test Message"; //there should be UserName and User password

                Mail::send('emails.user-changepassword', $viewData, function($message) use ($toEmail, $fromEmail, $subject) {
                    $message->to($toEmail['email'], $toEmail['name']);
                    $message->from($fromEmail['email'], $fromEmail['name']);
                    $message->subject($subject);
                });
            }
            return Redirect::back();
            //return Redirect::to('user/index')->withErrors($validator);
        }
        return Redirect::to('user/index')->withErrors($validator);
    }

}
