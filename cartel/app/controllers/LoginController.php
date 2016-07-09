<?php
class LoginController extends BaseController {

  /*------------------------------------------------------------------------*/
  /* __construct(): default constructor */
  /*------------------------------------------------------------------------*/
  public function __construct() {
    parent::__construct(); 
    $this->beforeFilter('csrf', ['on' => 'post']);
	}	// __construct()
  
  /**-------------------------------------------------------------------------
  * login():  opens the login screen 
  *
  * @return Response
  *-------------------------------------------------------------------------*/
	public function login() {
		if(Auth::check()){
		  return Redirect::to('create-edit-a-post')
							->with('messages', 'You are already logged in');
    }

    
    if (Session::get('loginAttempts', function() { return '0'; }) >= 3) {
         
      $timeElapsed = time() - Session::get('lockoutTime', 
                                  function() { return time(); });
      if ($timeElapsed < $this->pageData['lockoutTime']) {	
        $timeRemaining = $this->pageData['lockoutTime'] - $timeElapsed;
        if($timeRemaining >= 60) {
          $timeRemaining++; 
          $msg = "Login attempts will be suspended for ".
            date('i', $timeRemaining)." minute(s).";	
        }
        else {	
          $msg = "Login attempts will be suspended for ".
            date('s', $timeRemaining)." seconds.";
        }
        $disableLoginForm = 'disabled';
      }
      else {
         
        $disableLoginForm = '';
        Session::put('loginAttempts', 0);			
        Session::put('lockoutTime', 0);			
        $msg = NULL;
      }
      return View::make('login')
        ->withErrors($msg)
        ->with('disableLoginForm', $disableLoginForm);
    }
    else {
       
      //Session::put('loginAttempts', 0);
      $disableLoginForm = '';
      return View::make('login')
        ->with('disableLoginForm', $disableLoginForm);
    }
    
  } // login()

  /**-------------------------------------------------------------------------
  * trylogin(): Accepts login post data and attempts to log the user in.
  *
  * @return Response
  *-------------------------------------------------------------------------*/
	public function trylogin() {
		/*  Get inbound form values  */
		$username = Input::get('username');
		$password = Input::get('password');

		$userInfo = User::whereRaw("username = ?", array($username))
			->get(array('id', 'name', 'status_id', 'password', 'defaultlanguage_id'));
      
		/* If good, go to intended page, if not go back with errors */
		if (!count($userInfo)) {
			Session::put('loginAttempts', 1+Session::get('loginAttempts',
        function() { return '0'; }));
			if(Session::get('loginAttempts', function() { return '0'; }) == 3)
        Session::put('lockoutTime', time());

			/* Redirect to avoid any refresh issues */
			$msg="Your Username / Password do not match our records. Attempt ".
        Session::get('loginAttempts', 
          function() { return '0'; })." of 3. Please try again.
            If you continue to have difficulty, please contact Cartel
            Marketing for assistance.";
			return Redirect::back()
					->withInput()
					->withErrors($msg);
			//$redir_url="login.php?s=1&ref=$ref&msg=$msg";
		} 
    else {
			if (Hash::check($password, $userInfo[0]->password)) {
				if ($userInfo[0]->status_id != 1) {	
          $msg = "Your account is not active.
                Please contact Cartel Marketing for assistance.";
					return Redirect::back()
            ->withInput()
            ->withErrors($msg);
				} 
        else {
					/* Run standard Laravel AuthCheck to set it's variables */
					$credentials = ['username' => $username, 'password' => $password];
          
          // the "true" is to remember the user
					$attempt = Auth::attempt($credentials, true); 

					if($attempt)	{
						$language = Language::find($userInfo[0]->defaultlanguage_id);
            
            /* Store that the user is has logged in */
            DatabaseSession::addUserIdToSession(Auth::user()->id);
            Auth::user()->updateLastOnlineTime();
            
						/* Set session variables to track their Terms Of Use acceptance */
						Session::put('default_lang', $language->code);
						Session::put('terms', 0);

						/* Redirect to avoid any refresh issues */
            if(Config::get('config.devMachine'))
              return Redirect::intended('/view-the-board');
              
						return Redirect::intended('/terms-of-use');
					}
					else {
						Session::put('loginAttempts', 1 + Session::get('loginAttempts',
              function() { return '0'; }));
						if(Session::get('loginAttempts', function() { return '0'; }) == 3) {	
              Session::put('lockoutTime', time());
            }

						/* Redirect to avoid any refresh issues */
						$msg = "Your Username / Password do not match our records. Attempt ".
                  Session::get('loginAttempts', 
                    function() { return '0'; }).
                    " of 3. Please try again.  If you continue to have
                      difficulty, please contact Cartel Marketing for
                      assistance.";
						return Redirect::intended('/')
							->withErrors($msg);
					}
				}
			} 
      else {
				Session::put('loginAttempts', 1+Session::get('loginAttempts',
            function() { return '0'; }));
				if(Session::get('loginAttempts', function() { return '0'; }) == 3) {	
          Session::put('lockoutTime', time());
        }

				/* Redirect to avoid any refresh issues */
				$msg="Your Username / Password do not match our records. Attempt ".
          Session::get('loginAttempts', function() { return '0'; }).
            " of 3. Please try again.  If you continue to have difficulty,
              please contact Cartel Marketing for assistance.";
				return Redirect::back()
          ->withInput()
          ->withErrors($msg);
			}
		}
	} // trylogin()
  
	/**-------------------------------------------------------------------------
	* logout(): Logs the user out of the system
  *
	* @return Response
	*-------------------------------------------------------------------------*/
	public function logout() {
		Auth::logout();
    /* Set the user as offline */
    DatabaseSession::addUserIdToSession(0);
    
		Session::forget('default_lang');
		Session::forget('loginAttempts');
		Session::forget('lockoutTime');
               
		return Redirect::to('/');
	} // logout()
        
   /**------------------------------------------------------------------------
   * admin():       Opens the admin page if the user is logged in, login
   *                page otherwise.
   *
   * @return Response
   *-------------------------------------------------------------------------*/
  public function admin() {
    if(Auth::check())
      return View::make('admin.admin');
    else
      return Redirect::to('/login');
  } // admin()
} // Class
?>
