<?php

use \RobBrazier\Piwik\Piwik;

class AdminController extends BaseController {

    public $admin;

    public function __construct() {
        $this->admin = User::searchAdmin();
        $this->beforeFilter(function(){
            if(!Auth::check()) {
                return View::make('login.login');
            }
        });
    }

     public function registerUser() {
        $validator = Validator::make(
                        array(
                    'first_name' => Input::get('first_name'),
                    'last_name' => Input::get('last_name'),
                    'password' => Input::get('password'),
                    'email' => Input::get('email')
                        ), array(
                    'first_name' => 'required|alpha_num|min:2',
                    'last_name' => 'required|alpha_num|min:2',
                    'password' => 'required|alpha_num|between:6,12',
                    'email' => 'required|email'
                        )
        );
        if ($validator->fails()) {
            return Redirect::to('userslist')->withErrors($validator)->withInput()->with('user_section', true);
        } else {
            $users = User::findUserByEmail(array('email' => Input::get('email')));
            if (count($users) > 0) {
                return Redirect::to('userslist')->with('error', 'Username or Email used from another user.')->with('user_section', true);
            }
            $data['password'] = Hash::make(Input::get('password'));
            $data['remember_token'] = Input::get('_token');
            $data['first_name'] = Input::get('first_name');
            $data['last_name'] = Input::get('last_name');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['email'] = Input::get('email');
            $data['token_auth'] = md5(Hash::make(Input::get('password')).time());
            //$data['role'] = 1;
            $register = User::registerUser($data);
            if ($register) {
                /*  $userData  = array(
                  'email' 	=> Input::get('email'),
                  'password' 	=> Input::get('password')
                  );
                  if(Auth::attempt($userData)){
                  return Redirect::route('dashboard')->with('message', 'Welcome to our demo API '.ucfirst(Auth::user()->username).'.');
                  } */

                $viewData = array(); // Data to pass to emails/pdf views
                if (Config::get('mail.pretend')) {
                    $pretendView = "";
                    $pretendView .= '<br /><br />EMAILS:<br />';
                    $pretendView .= View::make('emails.user-create');

                    echo $pretendView;
                    return true;
                }

                /* ------------------------------------------------------------- */
                /* Email to created user */
                /* ------------------------------------------------------------- */

                $toEmail = array('email' => Input::get('email'), 'name' => Input::get('first_name') . " " . Input::get('last_name'));
                $fromEmail = array('email' => 'vardan.meloyan92@gmail.com',
                    'name' => 'Your Name');
                $subject = "Your UserName: " . Input::get('email') . "<br> Your Password : " . Input::get('password'); //there should be UserName and User password

                Mail::send('emails.user-create', $viewData, function($message) use ($toEmail, $fromEmail, $subject) {

                    $message->to($toEmail['email'], $toEmail['name']);
                    $message->from($fromEmail['email'], $fromEmail['name']);
                    $message->subject($subject);
                });
                return Redirect::to('userslist')->with('error', 'User successfully created')->with('user_section', true);
            } else {
                return Redirect::to('userslist')->with('error', 'Your registration failed.')->with('user_section', true);
            }
        }
    }

    public function visualization() {
        if (Auth::check()) {
            return View::make('admin.visualization.visualization')->with('home', true);
        }
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

    public function getDashboard() {
        //echo "888";die;
        return View::make('admin.dashboard.dashboard')->with('home', true);
    }

    public function profile() {
        return View::make('admin.profile.profile');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function editAccount() {
        return View::make('admin.profile.edit_account');
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
            return Redirect::route('edit-admin-account', Auth::user()->id)->withErrors($validator)->withInput();
        } else {
            $data = Input::except('correct_password');
            unset($data["_token"]);
            $changeAccount = User::changeAccountSettings($data);
            if ($changeAccount) {
                return Redirect::route('admin_profile')->with('message', 'Your account successfully updated.');
            } else {
                return Redirect::route('admin_profile')->with('error_mes', 'ERROR! Please try again later.');
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
            return Redirect::route('edit-admin-account', Auth::user()->id)->withErrors($validator)->withInput()->with('change', 'change_pass');
        } else {
            $data['password'] = Hash::make(Input::get('new_password'));
            $changeAccount = User::changeAccountSettings($data);
            if ($changeAccount) {
                return Redirect::route('admin_profile')->with('message', 'Your password updated successfully.');
            } else {
                return Redirect::route('admin_profile')->with('error', 'ERROR! Please try again later.');
            }
        }
    }

    public function userlist() {
        $users = User::listAllUsers();
//        echo "<pre>";var_dump($users);die;
        return View::make('admin.user.index')
                        ->with('users', $users)->with('user_section', true);
    }
    
    public function deleteUserById($id) {
        User::deleteUser($id);
        return Redirect::route('user_index');
    }

    public function sitelist() {
        $users_site = Sites::listAllSites();
//        echo "<pre>";
//        print_r($users_site);die;
        return View::make('admin.site.site')
                        ->with('users_site', $users_site)->with('site_section', true);
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
     public function delete() {
        $user_id = Input::get('user_id');
        $user = User::deleteUser($user_id);
        // $delete = $user->delete();
        print_r($user);
        die;
    }

}
