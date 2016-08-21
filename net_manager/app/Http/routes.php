<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */


/*
  ############################################################################################
  # Frontend Routes
  ############################################################################################
 */

Route::group(['as' => 'f::', 'namespace' => 'Frontend',], function () {

    Route::get('/', ['as' => 'index', 'uses' => 'DefaultController@index']);
});

/*
  ############################################################################################
  # Backend Routes
  ############################################################################################
 */


Route::group(['prefix' => 'admin', 'as' => 'b::', 'namespace' => 'Backend', 'middleware' => ['auth']], function () {

    /* I. ADMIN ROUTES */

    /* GENERAL VIEWS */
    Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DefaultController@dashboard']);


    /* USER MANAGEMENT */

    Route::group(['as' => 'user::', 'middleware' => []], function () {

        Route::resource('users', 'UserController', [
            'names' => [
                'index' => 'index',
                'store' => 'store',
                'edit' => 'edit',
                'create' => 'create',
                'update' => 'update'
            ]
                ]
        );
    });



    /** Role_permissions */
    /*** Create new roles ***/

    /*** Create new permission ***/
    Route::get('/permission/create', ['as' => 'create_permission', 'uses' => 'UserController@createPermission']);
    Route::post('/permission/create', ['as' => 'save_permission', 'uses' => 'UserController@storePermission']);

    /* Media MANAGEMENT */

    Route::get('/media-library/show', ['as' => 'media_library', 'uses' => 'DefaultController@showMedia']);


    /* FINANCIAL MANAGEMENT */
    /** Payments * */
    Route::get('/payments/index', ['as' => 'payments_index', 'uses' => 'FinancialController@b2cpaymentsIndex']);
    Route::get('/payments/{id}/show', ['as' => 'payments_show', 'uses' => 'FinancialController@b2cpaymentsShow']);
    /*     * Declarations * */
    Route::get('/declarations/index', ['as' => 'declarations_index', 'uses' => 'FinancialController@declarationsIndex']);
    Route::get('/declaration/{id}/show', ['as' => 'declarations_show', 'uses' => 'FinancialController@declarationsShow']);
    /*     * Invoices * */
    Route::get('/invoices/index', ['as' => 'invoices_index', 'uses' => 'FinancialController@invoicesIndex']);
    Route::get('/invoices/{id}/show', ['as' => 'invoices_show', 'uses' => 'FinancialController@invoicesShow']);


    /* II. COACH ROUTES */
    Route::group(['prefix' => 'coach', 'as' => 'coach::', 'middleware' => ['web', 'auth']], function () {

        Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DefaultController@dashboard']);
    });

    /* III. PLAYER ROUTES */
    Route::group(['prefix' => 'player', 'as' => 'player::', 'middleware' => ['web', 'auth']], function () {

        Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DefaultController@dashboard']);
    });

    /* IV. FOLLOWERS ROUTES */
    Route::group(['prefix' => 'follower', 'as' => 'follower::', 'middleware' => ['web', 'auth']], function () {

        Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DefaultController@dashboard']);
    });

    /* V. PARENTS ROUTES */
    Route::group(['prefix' => 'parent', 'as' => 'parent::', 'middleware' => ['web', 'auth']], function () {

        Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DefaultController@dashboard']);
    });

    /* Static Pages MANAGEMENT */
    /** Index,Create,Edit * */
    Route::group(['prefix' => 'pages', 'as' => 'pages::', 'middleware' => []], function () {

        Route::get('/', ['as' => '', 'uses' => 'StaticPageController@index']);
        Route::get('/create', ['as' => 'create', 'uses' => 'StaticPageController@create']);
        Route::post('/store', ['as' => 'store', 'uses' => 'StaticPageController@store']);
        Route::get('/edit/{id}', ['as' => 'edit', 'uses' => 'StaticPageController@edit']);
        Route::post('/update/{id}', ['as' => 'update', 'uses' => 'StaticPageController@update']);
        Route::get('/delete/{id}', ['as' => 'delete', 'uses' => 'StaticPageController@delete']);

    });
    
    /* Blog Article MANAGEMENT */
    /** Index,Create,Edit * */
    Route::group(['prefix' => 'blog', 'as' => 'blog::', 'middleware' => []], function () {

        Route::get('/', ['as' => '', 'uses' => 'BlogController@index']);
        Route::get('/create', ['as' => 'create', 'uses' => 'BlogController@create']);
        Route::post('/store', ['as' => 'store', 'uses' => 'BlogController@store']);
        Route::get('/edit/{id}', ['as' => 'edit', 'uses' => 'BlogController@edit']);
        Route::post('/update/{id}', ['as' => 'update', 'uses' => 'BlogController@update']);
        Route::get('/delete/{id}', ['as' => 'delete', 'uses' => 'BlogController@delete']);

    });
});

/*
  ############################################################################################
  # Auth Routes
  ############################################################################################
 */

Route::auth();



