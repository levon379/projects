<?php

use App\Language;

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

// first get all language code
$langCodes = Language::all()->lists('code');

// get locale from url
$locale = Request::segment(1);
if (in_array($locale, $langCodes)) {
    \App::setLocale($locale);
} else {
    $locale = 'en';
}

// now set dynamic lang based urls for city, category and products
Route::group(array('prefix' => $locale), function()
{
	Route::get('/', 'HomeController@index');
	Route::get('/about-ecoart-travel', 'HomeController@about');
	Route::get('/{cityOrCatSlug}', 'ProductsController@index');
	Route::get('/{citySlug}/{productURL}', 'ProductsController@viewProduct');

});

Route::get('/about', 'HomeController@about');


Route::get('/images/addons/{id}', 'ImagesController@viewAddonImage');
Route::get('/images/providers/{id}', 'ImagesController@viewProviderImage');
// {type} -> default , thumb, preview
Route::get('/images/{image_hash}/{type}', 'ImagesController@viewProductImage');

Route::get('/blog', 'BlogController@index');
Route::get('/blog/{id}', 'BlogController@viewBlog');

//product list
//Route::get('/things-to-do-in-rome', 'ProductsController@index');

//day trips
//Route::get('/day-trips-from-rome', 'ProductsController@index'); //still points to product list but list is filtered showing day trips only
//Route::get('/day-trips-from-rome/{id}/{name?}/{language?}', 'ProductsController@viewProduct');
//Route::post('/day-trips-from-rome/{id}/{name}/book', 'ProductsController@book');

//tours
//Route::get('/rome-segway-tours', 'ProductsController@index'); //still points to product list but list is filtered showing tours only
//Route::get('/rome-segway-tours/{id}/{name?}', 'ProductsController@viewProduct');

Route::post('/products/{id}/book', 'ProductsController@book');

Route::get('/products/success', 'ProductsController@success');

Route::get('/partner-page', 'PartnerPageController@index');

Route::get('/shopping-cart', 'ShoppingCartController@index');
Route::post('/shopping-cart/remove-item/{id}', 'ShoppingCartController@removeItem');
Route::post('/shopping-cart/add-promo-code', 'ShoppingCartController@addPromoCode');
Route::post('/shopping-cart/checkout', 'ShoppingCartController@postCheckout');
Route::get('/add-tours', 'ShoppingCartController@addTours');
Route::get('/shopping-cart/order-summary', 'ShoppingCartController@orderSummary');
Route::get('/shopping-cart/gestpay-callback', 'ShoppingCartController@gestpayCallback');
Route::get('/shopping-cart/gestpay-server-callback', 'ShoppingCartController@gestpayServerCallback');
Route::get('/services/bookings/compute/tourprice','BookingServicesController@computeTourPrice');
Route::get('/services/products/options/product','ProductOptionsServicesController@getProductOptionsByProductIdLanguageIdAndDate');
Route::get('/services/products/options/language','ProductOptionsServicesController@getProductOptionLanguagessByProductIdAndDate');
Route::get('/services/products/options/childprice','ProductOptionsServicesController@getProductOptionChildPrice');
Route::get('/services/products/options/childAge','ProductOptionsServicesController@getProductOptionChildAge');
Route::get('/services/products/options/AdultAge','ProductOptionsServicesController@getProductOptionAdultAge');
Route::get('/services/bookings/validate-date','BookingServicesController@validateDate');
Route::post('/services/newsletter/subscribe', 'HomeController@postSubscribeNewsletter');
Route::get('/bookings/{id}/voucher/print', 'BookingsController@getPrintVoucher');
Route::get('/video_thumb/{video_id}', 'ImagesController@viewProductVideoThumb');
Route::get('home', 'HomeController@index');

Route::get('contact/sendemail', 'HomeController@getSendContactEmail');

// troubleshooting route
Route::get('/test', 'HomeController@getTest');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);















#301 Redirects
Route::get('/', function(){ 
    return Redirect::to('/en', 301); 
});
Route::get('/day-trips-from-rome', function(){ 
    return Redirect::to('', 301); 
});
Route::get('/day-trips-from-rome', function(){ 
    return Redirect::to('/en/day-trips-from-rome', 301); 
});
Route::get('/photos', function(){ 
    return Redirect::to('/en', 301); 
});
Route::get('/rome-segway-tours', function(){ 
    return Redirect::to('/en/rome-segway-tours', 301); 
});
Route::get('/testimonials', function(){ 
    return Redirect::to('/about-ecoart-travel', 301); 
});
Route::get('/about-ecoart-travel', function() use ($locale){ 
    return Redirect::to("{$locale}/about-ecoart-travel", 301); 
});
Route::get('/day-trips-from-rome/ponza-island-day-trip-from-rome', function(){ 
    return Redirect::to('/en/things-to-do-in-rome/ponza-island-day-trip-from-rome-snorkeling', 301); 
});
Route::get('/day-trips-from-rome/sperlonga-beach-day-trip-from-rome', function(){ 
    return Redirect::to('/en/things-to-do-in-rome/sperlonga-beach-day-trips-from-rome', 301); 
});
Route::get('/colosseum-vatican-tickets', function(){ 
    return Redirect::to('/en/rome-tickets', 301); 
});
Route::get('/ticket-request-form', function(){ 
    return Redirect::to('/en/rome-transfers', 301); 
});
// Route::get('', function(){ 
//     return Redirect::to('', 301); 
// });
