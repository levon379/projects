<?php
class BaseController extends Controller {

  public $pageData;
  public $userInfo;

  /*------------------------------------------------------------------------*/
  /* __construct(): default constructor */
  /*------------------------------------------------------------------------*/
  public function __construct() {
		$this->pageData = array();

		/* Set the User's Permissions throughout the site */
		if(Auth::check()) {
			/* Set the user permissions, from models/user.php */ 
			$this->userInfo = Auth::getUser();
			if($this->userInfo->perm_groups != 0) {
        $this->pageData['permissions'] =
          User::setAccessLevel($this->userInfo->perm_groups);
      }
			else {
        $this->pageData['permissions'] = 0;    
      }
		}
		else {
			$this->pageData['permissions'] = 0;
		}

		/* Determine and set the language that should be displayed
		    Language priorities:  
          Current Choice (session variable), 
          User Default Lang (if avail for a given Locale), 
          Locale default, 
          Laravel Default
    */
		$siteLanguageID = 0;
    
    /* Hardcoded to 1 since there is currently only one location.  Should come
    from the URI path (ie. /windsor/) */
    $localeInfo = Localization::findOrFail(1);   
    
		/* Check for a session language (defaults to 0 if not found) */ 
		if(!Session::get('default_lang', 0)) {
			/* Since no session info, check to see if they're logged in */ 
			if(Auth::check()) {
				$this->userInfo = Auth::getUser();
				$siteLanguageID = $this->userInfo->defaultlanguage_id;
			}
      /* Since not logged in, get this board's default language */ 
			else {
				$siteLanguageID = $localeInfo->default_language_id;
			}

			/* Set the Session and App::Locale to the appropriate language */ 
			$langInfo = Language::findOrFail($siteLanguageID);
			Session::put('default_lang', $langInfo->code, App::getLocale());
			App::setLocale($langInfo->code);
		}
		else {	
      /* Since there is session info, get the language in there and then*/
      /* lookup the ID of that language*/
			/* Set Laravel to the appropriate language (don`t confuse Laravel*/
      /* LOCALE (the language) with Cartel LOCALE(the geo/board)*/
			App::setLocale(Session::get('default_lang', App::getLocale()));
			$langInfo = Language::where("code", "=", App::getLocale())->first();
			$siteLanguageID = $langInfo->id;
		}
	
		/* Set some standard pageData values */ 
		$this->pageData['language_id'] = $siteLanguageID;
		$this->pageData['locale_id']   = $localeInfo->id;
		$this->pageData['localeName']  = $localeInfo->name;
		$this->pageData['localeLangs'] = $localeInfo->languages;

    /* App colors */
		$this->pageData['success']     = 'LightGreen';
		$this->pageData['error']       = 'LightPink';
		$this->pageData['warning']     = 'LemonChiffon';
		$this->pageData['neutral']     = 'SkyBlue';

		$this->pageData['lightGreen']  = 'LightGreen';
		$this->pageData['darkGreen']   = 'LimeGreen';
		$this->pageData['lightPink']   = 'LightPink';

	}	// __construct()
  
  /**-------------------------------------------------------------------------
   * setupLayout():
   *                  default Laravel code (do not remove)
   *--------------------------------------------------------------------------
   *-------------------------------------------------------------------------*/
	protected function setupLayout() {
		if (!is_null($this->layout)) {
			$this->layout = View::make($this->layout);
		}
	} // setupLayout()
} // class
