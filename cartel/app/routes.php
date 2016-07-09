<?php
/*--------------------------------------------------------------------------*/
/* View::composer(*):  Ran before all views are rendered */
/*--------------------------------------------------------------------------*/
View::composer('*', function($view){
  $navAdminVisible  = false; // Show/hide the "admin" nav button
  $navLoginVisible  = false; // Show/hide the admin login button
  $navLogoutVisible = false; // Show/hide the admin logout button
  $userInfo         = array();  // The current user's info

  if(Auth::check()) {
    /* Update the User's last-online time */
    /* Sessions are stored in the database. This adds a user_id to a session key */
    DatabaseSession::addUserIdToSession(Auth::user()->id);
    Auth::user()->updateLastOnlineTime(); // Store the last-online time
    
    /* ------------------------------------------------------
    /* Show the 'logout' button in the nav bar */
    $navLogoutVisible = true;
    $navLoginVisible = false;
    $userInfo = Auth::getUser();
    
    /* If the user is an admin, show the "admin" button in the nav bar */
    if($userInfo->perm_groups == '1' ||
      $userInfo->perm_groups == '2' ||
      $userInfo->perm_groups == '4')
      $navAdminVisible = true;
  }
  else{
    /* If the user is logged in, show the 'login' button in the nav bar */
    $navLogoutVisible = false;
    $navLoginVisible = true;
  }
  
  /* Pass "Help" content to the view, along with userInfo and nav flags */
  if(HelpButtonController::hasHelp($view->getName())) {
    $help = HelpButtonController::getHelp($view->getName());
    $view->with('help', $help['helpMessage'])
         ->with('helpTitle', $help['helpTitle'])
         ->with('userInfo', $userInfo)
         ->with('navLoginVisible', $navLoginVisible)
         ->with('navLogoutVisible', $navLogoutVisible)
         ->with('navAdminVisible', $navAdminVisible);
    return;
  }
  
  /* Pass only userInfo and nav flags */
  $view->with('userInfo', $userInfo)
       ->with('navLoginVisible', $navLoginVisible)
       ->with('navLogoutVisible', $navLogoutVisible)
       ->with('navAdminVisible', $navAdminVisible);
});

/*--------------------------------------------------------------------------*/
/*	Public Routes - no login required                          							*/
/*--------------------------------------------------------------------------*/
/* Index Routes */
Route::get('/', 'IndexController@index');

/* Login */
Route::get('login', 'LoginController@login');
Route::post('trylogin', 'LoginController@trylogin');
Route::get('logout', 'LoginController@logout');

/* Terms of Use */
Route::get('terms-of-use', 'TermsOfUseController@termsOfUse');
Route::post('terms-of-use', 'TermsOfUseController@submitTermsOfUse');

/*--------------------------------------------------------------------------*/
/* User routes - routes requireing at least a customer login */
/*--------------------------------------------------------------------------*/
Route::group(array('before' => 'auth'), function(){
  
  /* Contact Us */
  Route::get('contact-us', 'ContactUsController@index');
  Route::post('contact-us', 'ContactUsController@submit');
  
  /* PostTo (and children) Routes */
  Route::get('create-edit-a-post', array('before' => 'auth', 'uses' => 'CreateEditAPostController@index'));
  Route::get('create-edit-a-post-favorites', array('before' => 'auth', 'uses' => 'CreateEditAPostController@favorites'));
  Route::get('create-edit-a-post-past', array('before' => 'auth', 'uses' => 'CreateEditAPostController@past'));

  Route::get('post-to-buy', array('before' => 'auth', 'uses' => 'PostToController@create'));
  Route::get('post-to-buy/{id}/edit', 'PostToController@create');
  Route::get('post-to-buy/{id}/delete', 'PostToController@destroy');
  Route::get('post-to-buy/{id}/favorite', 'PostToController@favorite');
  Route::get('post-to-buy/{id}/repost', 'PostToController@repost');
  Route::post('post-to-buy/{id}/counter-repost', 'PostToController@counterRepost');
  Route::get('post-to-buy/{id}/preview', 'PostToController@preview');
  Route::post('post-to-buy/{id}/store', 'PostToController@store');
  Route::get('post-to-buy/{id}/commit', 'PostToController@commit');

  Route::get('post-to-sell', array('before' => 'auth', 'uses' => 'PostToController@create'));
  Route::get('post-to-sell/{id}/edit', 'PostToController@create');
  Route::get('post-to-sell/{id}/delete', 'PostToController@destroy');
  Route::get('post-to-sell/{id}/favorite', 'PostToController@favorite');
  Route::get('post-to-sell/{id}/repost', 'PostToController@repost');
  Route::post('post-to-sell/{id}/counter-repost', 'PostToController@counterRepost');
  Route::get('post-to-sell/{id}/preview', 'PostToController@preview');
  Route::post('post-to-sell/{id}/store', 'PostToController@store');
  Route::get('post-to-sell/{id}/commit', 'PostToController@commit');

  /* ViewTheBoard Routes */
  Route::get('/view-the-board', array('before' => 'auth', 'uses' => 'ViewTheBoardController@main'));
  Route::get('/view-the-board-closed', array('before' => 'auth', 'uses' => 'ViewTheBoardController@closed'));

  Route::get('/view-the-board/edit', array('before' => 'auth', 'uses' => 'ViewTheBoardController@edit'));
  Route::post('/view-the-board/edit', array('before' => 'auth', 'uses' => 'ViewTheBoardController@update'));

  /* BidTo (and children) Routes */
  Route::get('bid-to-sell/{id}/bid', 'BidToController@create');
  Route::post('bid-to-sell/{id}/store', 'BidToController@store');

  Route::get('bid-to-buy/{id}/bid', 'BidToController@create');
  Route::post('bid-to-buy/{id}/store', 'BidToController@store');

  Route::get('view-bid/{id}/view', 'ViewBidToController@main');
  Route::post('view-bid/{id}/store', 'ViewBidToController@store');

  Route::get('email-testing', 'EmailTestingController@main');
  /* How did you hear about us? On the index page */
  Route::post('/referrals', 'FeedbackController@processReferral');
});

/*--------------------------------------------------------------------------*/
/*    ADMIN ROUTES
/*--------------------------------------------------------------------------*/
Route::group(array('before' => 'auth'), function(){
  /* Main admin Menu */
  Route::get('/admin_menu', array('before' => 'auth', 'uses' => 'AdminMainMenuController@main'));

  /* Admin color - add/remove product color options */
  Route::get('admin-colour', 'AdminColourController@index');
  Route::get('admin-colour/{id}/edit', 'AdminColourController@edit');
  Route::post('admin-colour/{id}/store', 'AdminColourController@store');
  Route::get('admin-colour/{id}/destroy', 'AdminColourController@destroy');
  Route::get('admin-colour/{id}/{swap_id}/swap', 'AdminColourController@swap');

  /* Admin maturity - add/remove product maturity options */
  Route::get('admin-maturity', 'AdminMaturityController@index');
  Route::get('admin-maturity/{id}/edit', 'AdminMaturityController@edit');
  Route::post('admin-maturity/{id}/store', 'AdminMaturityController@store');
  Route::get('admin-maturity/{id}/destroy', 'AdminMaturityController@destroy');
  Route::get('admin-maturity/{id}/{swap_id}/swap', 'AdminMaturityController@swap');

  /* Admin package - add/remove product packaging options */
  Route::get('admin-package', 'AdminPackageController@index');
  Route::get('admin-package/{id}/edit', 'AdminPackageController@edit');
  Route::post('admin-package/{id}/store', 'AdminPackageController@store');
  Route::get('admin-package/{id}/destroy', 'AdminPackageController@destroy');
  Route::get('admin-package/{id}/{swap_id}/swap', 'AdminPackageController@swap');

  /* Admin quality - add remove product quality options */
  Route::get('admin-quality', 'AdminQualityController@index');
  Route::get('admin-quality/{id}/edit', 'AdminQualityController@edit');
  Route::post('admin-quality/{id}/store', 'AdminQualityController@store');
  Route::get('admin-quality/{id}/destroy', 'AdminQualityController@destroy');
  Route::get('admin-quality/{id}/{swap_id}/swap', 'AdminQualityController@swap');

  /* Admin weight types - add/remove weight units (kg, g, lbs) */
  Route::get('admin-weight-type', 'AdminWeightTypeController@index');
  Route::get('admin-weight-type/{id}/edit', 'AdminWeightTypeController@edit');
  Route::post('admin-weight-type/{id}/store', 'AdminWeightTypeController@store');
  Route::get('admin-weight-type/{id}/destroy', 'AdminWeightTypeController@destroy');
  Route::get('admin-weight-type/{id}/{swap_id}/swap', 'AdminWeightTypeController@swap');

  /* Admin product categories - (products which may have parents) */
  Route::get('admin-category', 'AdminCategoryController@index');
  Route::get('admin-category/{id}/edit', 'AdminCategoryController@edit');
  Route::post('admin-category/{id}/store', 'AdminCategoryController@store');
  Route::get('admin-category/{id}/destroy', 'AdminCategoryController@destroy');

  /* Admin countries */
  Route::get('admin-country', 'AdminCountryController@index');
  Route::get('admin-country/{id}/edit', 'AdminCountryController@edit');
  Route::post('admin-country/{id}/store', 'AdminCountryController@store');
  Route::get('admin-country/{id}/destroy', 'AdminCountryController@destroy');

  /* Admin provices/states etc. */
  Route::get('admin-province/{parent_type}/{id}/edit', 'AdminProvinceController@edit');
  Route::post('admin-province/{id}/store', 'AdminProvinceController@store');
  Route::get('admin-province/{parent_type}/{id}/destroy', 'AdminProvinceController@destroy');

  /* Admin place of origin options */
  Route::get('admin-origin', 'AdminOriginController@index');
  Route::get('admin-origin/{id}/edit', 'AdminOriginController@edit');
  Route::post('admin-origin/{id}/store', 'AdminOriginController@store');
  Route::get('admin-origin/{id}/destroy', 'AdminOriginController@destroy');

  /* Admin site content */
  Route::get('admin-content/{content_group}/{content_lang}', 'AdminContentController@index');
  Route::get('admin-content/{content_group}/{content_lang}/{id}/edit', 'AdminContentController@edit');
  Route::post('admin-content/{content_group}/{content_lang}/{id}/store', 'AdminContentController@store');

  /* Admin Company */
  Route::get('admin-company', 'AdminCompanyController@index');
  Route::get('admin-company/{id}/edit', 'AdminCompanyController@edit');
  Route::post('admin-company/{id}/store', 'AdminCompanyController@store');
  Route::get('admin-company/{id}/destroy', 'AdminCompanyController@destroy');

  /* Admin Company Address */
  Route::get('admin-company-address/{parent_id}', 'AdminCompanyAddressController@index');
  Route::get('admin-company-address/{parent_id}/{id}/edit', 'AdminCompanyAddressController@edit');
  Route::post('admin-company-address/{parent_id}/{id}/store', 'AdminCompanyAddressController@store');
  Route::get('admin-company-address/{id}/destroy', 'AdminCompanyAddressController@destroy');

  /* Admin user management */
  Route::get('admin-user/{id}/edit', 'AdminUserController@edit');
  Route::post('admin-user/{id}/store', 'AdminUserController@store');
  Route::get('admin-user/{id}/destroy', 'AdminUserController@destroy');
  Route::get('admin-user/list', 'AdminUserController@onlineUsers');
 
  /* Admin permissions */
  Route::get('admin-permission', 'AdminPermissionController@index');
  Route::get('admin-permission/{id}/edit', 'AdminPermissionController@edit');
  Route::post('admin-permission/{id}/store', 'AdminPermissionController@store');

  /* Admin order */
  Route::get('admin-order/{id}/show', 'AdminOrderController@show');
  Route::get('admin-order/{id}/edit', 'AdminOrderController@edit');
  Route::post('admin-order/{id}/store', 'AdminOrderController@store');

  /* Admin Recent Bids Report */
  Route::get('admin-reports-recent-bids', 'AdminReportsController@recentBids');
  Route::post('admin-reports-recent-bids', 'AdminReportsController@recentBids');
  
  
  /*Admin Uploader*/
  Route::get('admin-company/{id}/uploads', 'CompanyUploadsController@index');
  Route::post('admin-company/{id}/uploads', 'CompanyUploadsController@store');
  Route::post('admin-company/{id}/uploads/{file_id}/edit', 'CompanyUploadsController@edit');
  Route::get('admin-company/{id}/uploads/{file_id}', 'CompanyUploadsController@show');
  Route::any('admin-company/{id}/uploads/{file_id}/destroy', 'CompanyUploadsController@destroy');
  /************************/
  
  Route::get('admin-reports-completed-transactions', 'AdminReportsController@completedTransactions');
  Route::get('admin-reports-customer-history', 'AdminReportsController@customerHistory');
  Route::post('admin-reports-customer-history', 'AdminReportsController@customerHistory');
  Route::get('admin-reports/top-companies/{days}', 'AdminReportsController@topCompanies');
  Route::post('admin-reports/top-companies/', 'ConfigurationController@setMinimumBrokerage');
 

  /* Admin Product Images (RESTful) */
  Route::resource('admin-product-image', 'AdminProductImageController', array('except' => array('show')) );
}); // admin route group before auth

?>
