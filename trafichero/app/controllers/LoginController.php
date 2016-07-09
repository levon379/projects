<?php

class LoginController extends BaseController {

    public $role;
    public $super_admin;

    public function showLogin() {
        /* Check if the user is already logged in */
        if (Auth::check())
            if ($this->super_admin) {
                return Redirect::to('dashboard')->with('message', 'Welcome to our demo API ' . ucfirst(Auth::user()->username) . '.');
            } else {
                return Redirect::to('2/dashboard')->with('message', 'Welcome to our demo API ' . ucfirst(Auth::user()->username) . '.');
            }
        return View::make('login.login');
    }

// login()

    public function doLogin() {
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|alphaNum|min:3'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $userdata = array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
            );
            $this->super_admin = User::searchAdmin($userdata);
            if (Auth::attempt($userdata)) {
                if ($this->super_admin[0]->superuser_access) {
					$host = Request::getHost();
					$parts = explode('.', $host);
					$subdomain = $parts[0];
					if($subdomain == "admin")
					{
						return Redirect::to('dashboard')->with('message', 'Welcome to our demo API ' . ucfirst(Auth::user()->username) . '.');
					}else{
						Auth::logout();
						return Redirect::back()->with('error', 'Your username/password combination was incorrect');
					}
                    
                } else {
                    $user_sites = Sites::getUserFirstSite();
                    return Redirect::to($user_sites->idsite.'/dashboard')->with('message', 'Welcome to our demo API ' . ucfirst(Auth::user()->username) . '.');
                }
            } else {
                Auth::logout();
                return Redirect::back()->with('error', 'Your username/password combination was incorrect');
            }
        }
    }

    public function doLogout() {
        Auth::logout();
        Session::flush();
        return Redirect::to('/')->with('message', 'Your are now logged out.');
    }

}
