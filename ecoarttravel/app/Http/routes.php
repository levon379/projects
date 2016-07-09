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

Route::get('/', 'DashboardController@login');
Route::get('/images/providers/{id}', 'ImagesController@viewProviderImage');
Route::controller("/viator", "ViatorController");

Route::group(['middleware' => 'auth'],function(){

    Route::get('/images/addons/{id}', 'ImagesController@viewAddonImage');

    // {type} -> default , thumb, preview
    Route::get('/images/{image_hash}/{type}', 'ImagesController@viewProductImage');
    Route::get('/video_thumb/{video_id}', 'ImagesController@viewProductVideoThumb');


    Route::get('/admin', 'DashboardController@index');

    // booking calendar
    Route::get('/admin/tour-assignment-calendar','TourAssignmentCalendarController@index');
    Route::post('/admin/tour-assignment-calendar/confirm','TourAssignmentCalendarController@confirmGuide');
    Route::get('/admin/services/guide-tours', 'TourAssignmentCalendarServicesController@get');
    Route::post('/admin/services/add-availability', 'TourAssignmentCalendarServicesController@addUserAvailability');
    Route::post('/admin/services/remove-availability', 'TourAssignmentCalendarServicesController@removeUserAvailability');
    Route::get('/admin/services/get-availability', 'TourAssignmentCalendarServicesController@getUserAvailabilityList');

    Route::get('/admin/tour-manager/{id}/details', 'TourManagerController@details');

    Route::get('/admin/profile', 'ProfileController@edit');
    Route::post('/admin/profile', 'ProfileController@postEdit');

    // users languages services
    Route::get('/admin/services/languages','LanguagesServicesController@getAll');
    Route::get('/admin/services/languages/{id}' , 'LanguagesServicesController@getLanguageInfo')->where('id','[0-9]+');

    Route::group(['middleware' =>'admin'],function(){

         // tour manager
        Route::get('/admin/services/tour-manager/get','TourManagerServicesController@get');
        Route::get('/admin/services/tour-manager/all','TourManagerServicesController@getAll');
        Route::post('/admin/services/tour-manager/guide/update' , 'TourManagerServicesController@updateGuides');
        Route::post('/admin/services/tour-manager/option/update' , 'TourManagerServicesController@updateOption');
        Route::post('/admin/services/tour-manager/limit/update' , 'TourManagerServicesController@updateLimit');
        Route::post('/admin/services/tour-manager/note/update', 'TourManagerServicesController@updateNote');
        Route::post('/admin/services/tour-manager/note/delete', 'TourManagerServicesController@deleteNote');
        Route::get('/admin/services/tour-manager/services/options/price' , 'TourManagerServicesController@getPrice');
        Route::post('/admin/services/tour-manager/services/options/update' , 'TourManagerServicesController@updateService');
        Route::post('/admin/services/tour-manager/services/options/delete' , 'TourManagerServicesController@deleteService');
        Route::get('/admin/services/services' , 'TourManagerServicesController@getServices');
        Route::get('/admin/services/services/type' , 'TourManagerServicesController@getServicesTypes');
        Route::get('/admin/services/services/company' , 'TourManagerServicesController@getServicesByType');
        Route::get('/admin/services/services/option' , 'TourManagerServicesController@getServiceOptionByService');
        Route::get('/admin/services/tour-assignment-calendar/get','TourAssignmentCalendarServicesController@get');

        Route::get('/admin/tour-manager','TourManagerController@index');

        // statistics
        Route::get('/admin/statistics','StatisticsController@index');
        Route::get('/admin/statistics/add','StatisticsController@add');
        Route::post('/admin/statistics/add','StatisticsController@postAdd');
        Route::get('/admin/statistics/{id}/edit', 'StatisticsController@edit');
        Route::post('/admin/statistics/{id}/edit', 'StatisticsController@postEdit');
        Route::post('/admin/statistics/{id}/delete','StatisticsController@delete');

        // users
        Route::get('/admin/users','UsersController@index');
        Route::get('/admin/users/add','UsersController@add');
        Route::post('/admin/users/add','UsersController@postAdd');
        Route::get('/admin/users/{id}/edit', 'UsersController@edit');
        Route::post('/admin/users/{id}/edit', 'UsersController@postEdit');
        Route::post('/admin/users/{id}/delete','UsersController@delete');
        Route::get('/admin/services/guides', 'UsersServicesController@getGuides');
        Route::get('/admin/services/guides/sort', 'UsersServicesController@getGuidesByLanguage');

        // user types
        Route::get('/admin/users/types','UserTypesController@index');
        Route::get('/admin/users/types/add','UserTypesController@add');
        Route::post('/admin/users/types/add','UserTypesController@postAdd');
        Route::get('/admin/users/types/{id}/edit', 'UserTypesController@edit');
        Route::post('/admin/users/types/{id}/edit', 'UserTypesController@postEdit');
        Route::post('/admin/users/types/{id}/delete','UserTypesController@delete');

        // sources
        Route::get('/admin/sources/groups','SourceGroupsController@index');
        Route::get('/admin/sources/groups/add','SourceGroupsController@add');
        Route::post('/admin/sources/groups/add','SourceGroupsController@postAdd');
        Route::get('/admin/sources/groups/{id}/edit', 'SourceGroupsController@edit');
        Route::post('/admin/sources/groups/{id}/edit', 'SourceGroupsController@postEdit');
        Route::post('/admin/sources/groups/{id}/delete','SourceGroupsController@delete');

        Route::get('/admin/sources/names','SourceNamesController@index');
        Route::get('/admin/sources/names/add','SourceNamesController@add');
        Route::post('/admin/sources/names/add','SourceNamesController@postAdd');
        Route::get('/admin/sources/names/{id}/edit', 'SourceNamesController@edit');
        Route::post('/admin/sources/names/{id}/edit', 'SourceNamesController@postEdit');
        Route::post('/admin/sources/names/{id}/delete','SourceNamesController@delete');

        Route::get('/admin/services/sources/names/group','SourceNamesServicesController@getSourceNamesBySourceGroupId');

        // availability
        Route::get('/admin/availability/slots','AvailabilitySlotsController@index');
        Route::get('/admin/availability/slots/add','AvailabilitySlotsController@add');
        Route::post('/admin/availability/slots/add','AvailabilitySlotsController@postAdd');
        Route::get('/admin/availability/slots/{id}/edit', 'AvailabilitySlotsController@edit');
        Route::post('/admin/availability/slots/{id}/edit', 'AvailabilitySlotsController@postEdit');
        Route::post('/admin/availability/slots/{id}/delete','AvailabilitySlotsController@delete');

        Route::get('/admin/availability/rules','AvailabilityRulesController@index');
        Route::get('/admin/availability/rules/add','AvailabilityRulesController@add');
        Route::post('/admin/availability/rules/add','AvailabilityRulesController@postAdd');
        Route::get('/admin/availability/rules/{id}/edit', 'AvailabilityRulesController@edit');
        Route::post('/admin/availability/rules/{id}/edit', 'AvailabilityRulesController@postEdit');
        Route::post('/admin/availability/rules/{id}/delete','AvailabilityRulesController@delete');


        // users languages services
        Route::get('/admin/services/tods','TimeOfDaysServicesController@getAll');
        Route::get('/admin/services/tods/{id}' , 'TimeOfDaysServicesController@getTimeOfDayInfo')->where('id','[0-9]+');


        //payment methods
        Route::get('/admin/payment-methods','PaymentMethodsController@index');
        Route::get('/admin/payment-methods/add','PaymentMethodsController@add');
        Route::post('/admin/payment-methods/add','PaymentMethodsController@postAdd');
        Route::get('/admin/payment-methods/{id}/edit', 'PaymentMethodsController@edit');
        Route::post('/admin/payment-methods/{id}/edit', 'PaymentMethodsController@postEdit');
        Route::post('/admin/payment-methods/{id}/delete','PaymentMethodsController@delete');


        // websites
        Route::get('/admin/websites','WebsitesController@index');
        Route::get('/admin/websites/add','WebsitesController@add');
        Route::post('/admin/websites/add','WebsitesController@postAdd');
        Route::get('/admin/websites/{id}/edit', 'WebsitesController@edit');
        Route::post('/admin/websites/{id}/edit', 'WebsitesController@postEdit');
        Route::post('/admin/websites/{id}/delete','WebsitesController@delete');

        // website services
        Route::get('/admin/services/websites','WebsitesServicesController@getAll');
        Route::get('/admin/services/websites/{id}' , 'WebsitesServicesController@getWebsiteInfo')->where('id','[0-9]+');

        // product images placement service
        Route::get('/admin/services/products/images/placements','ProductImagePlacementsServicesController@getAll');
        Route::get('/admin/services/products/images/placements/{id}' , 'ProductImagePlacementsServicesController@getPlacement')->where('id','[0-9]+');

        // product videos placements service
        Route::get('/admin/services/products/videos/placements','ProductVideoPlacementsServicesController@getAll');
        Route::get('/admin/services/products/videos/placements/{id}' , 'ProductVideoPlacementsServicesController@getPlacement')->where('id','[0-9]+');


        // providers
        Route::get('/admin/providers','ProvidersController@index');
        Route::get('/admin/providers/add','ProvidersController@add');
        Route::post('/admin/providers/add','ProvidersController@postAdd');
        Route::get('/admin/providers/{id}/edit', 'ProvidersController@edit');
        Route::post('/admin/providers/{id}/edit', 'ProvidersController@postEdit');
        Route::post('/admin/providers/{id}/delete','ProvidersController@delete');

        // services
        Route::get('/admin/services','ServicesController@index');
        Route::get('/admin/services/add','ServicesController@add');
        Route::post('/admin/services/add','ServicesController@postAdd');
        Route::get('/admin/services/{id}/edit', 'ServicesController@edit');
        Route::post('/admin/services/{id}/edit', 'ServicesController@postEdit');
        Route::post('/admin/services/{id}/delete','ServicesController@delete');

        // service types
        Route::get('/admin/services/types','ServiceTypesController@index');
        Route::get('/admin/services/types/add','ServiceTypesController@add');
        Route::post('/admin/services/types/add','ServiceTypesController@postAdd');
        Route::get('/admin/services/types/{id}/edit', 'ServiceTypesController@edit');
        Route::post('/admin/services/types/{id}/edit', 'ServiceTypesController@postEdit');
        Route::post('/admin/services/types/{id}/delete','ServiceTypesController@delete');

        // service options
        Route::get('/admin/services/{serviceId}/options','ServiceOptionsController@index');
        Route::get('/admin/services/{serviceId}/options/add','ServiceOptionsController@add');
        Route::post('/admin/services/{serviceId}/options/add','ServiceOptionsController@postAdd');
        Route::get('/admin/services/options/{id}/edit', 'ServiceOptionsController@edit');
        Route::post('/admin/services/options/{id}/edit', 'ServiceOptionsController@postEdit');
        Route::post('/admin/services/options/{id}/delete','ServiceOptionsController@delete');

        // products
        Route::get('/admin/products','ProductsController@index');
        Route::get('/admin/products/add','ProductsController@add');
        Route::post('/admin/products/add','ProductsController@postAdd');
        Route::get('/admin/products/{id}/edit', 'ProductsController@edit');
        Route::post('/admin/products/{id}/edit', 'ProductsController@postEdit');
        Route::post('/admin/products/{id}/update', 'ProductsController@postUpdate');
        Route::post('/admin/products/{id}/delete','ProductsController@delete');
        Route::post('/admin/products/images/{id}/delete','ProductsController@deleteImage');
        Route::get('/admin/products/images/placements', 'ProductsController@getImagePlacements');
        Route::post('/admin/products/images/placements/add', 'ProductsController@postAddImagePlacement');
        Route::get('/admin/products/images/placements/{id}/edit', 'ProductsController@getImagePlacements');
        Route::post('/admin/products/images/placements/{id}/edit', 'ProductsController@postUpdateImagePlacement');
        Route::post('/admin/products/images/placements/{id}/delete', 'ProductsController@getImagePlacementDelete');

        Route::get('/admin/products/videos/placements', 'ProductsController@getVideoPlacements');
        Route::post('/admin/products/videos/placements/add', 'ProductsController@postAddVideoPlacement');
        Route::get('/admin/products/videos/placements/{id}/edit', 'ProductsController@getVideoPlacements');
        Route::post('/admin/products/videos/placements/{id}/edit', 'ProductsController@postUpdateVideoPlacement');
        Route::post('/admin/products/videos/placements/{id}/delete', 'ProductsController@getVideoPlacementDelete');
        Route::get('/admin/products/videos/placements/{videoId}/delete', 'ProductsController@getVideoDelete');


        Route::get('/admin/services/products','ProductsServicesController@getAll');

        // product categories services
        Route::get('/admin/services/categories','CategoriesServicesController@getAll');
        Route::get('/admin/services/categories/{id}' , 'CategoriesServicesController@getCategoryInfo')->where('id','[0-9]+');

        // product types
        Route::get('/admin/products/types','ProductTypesController@index');
        Route::get('/admin/products/types/add','ProductTypesController@add');
        Route::post('/admin/products/types/add','ProductTypesController@postAdd');
        Route::get('/admin/products/types/{id}/edit', 'ProductTypesController@edit');
        Route::post('/admin/products/types/{id}/edit', 'ProductTypesController@postEdit');
        Route::post('/admin/products/types/{id}/delete','ProductTypesController@delete');

        // product options
        Route::get('/admin/products/{productId}/options','ProductOptionsController@index');
        Route::get('/admin/products/{productId}/options/add','ProductOptionsController@add');
        Route::post('/admin/products/{productId}/options/add','ProductOptionsController@postAdd');
        Route::get('/admin/products/options/{id}/edit', 'ProductOptionsController@edit');
        Route::post('/admin/products/options/{id}/edit', 'ProductOptionsController@postEdit');
        Route::post('/admin/products/options/{id}/delete','ProductOptionsController@delete');

        Route::get('/admin/services/products/options/product','ProductOptionsServicesController@getProductOptionsByProductIdLanguageIdAndDate');
        Route::get('/admin/services/products/options/childprice','ProductOptionsServicesController@getProductOptionChildPrice');

        // product details
        Route::get('/admin/products/{productId}/details','ProductLanguageDetailsController@index');
        Route::get('/admin/products/{productId}/details/add','ProductLanguageDetailsController@add');
        Route::post('/admin/products/{productId}/details/add','ProductLanguageDetailsController@postAdd');
        Route::get('/admin/products/details/{id}/edit', 'ProductLanguageDetailsController@edit');
        Route::post('/admin/products/details/{id}/edit', 'ProductLanguageDetailsController@postEdit');
        Route::post('/admin/products/details/{id}/delete','ProductLanguageDetailsController@delete');

        Route::post('/admin/products/images/{id}/websites','ProductsController@addWebsitesToImage');
        Route::post('/admin/products/images/{id}/placements','ProductsController@addProductImageTypeToImage');
        Route::post('/admin/products/images/{id}/alttext','ProductsController@addAltTextToImage');
        Route::post('/admin/products/images/{id}/name','ProductsController@addUpdateImageName');

        Route::post('/admin/products/videos/{id}/placements','ProductsController@addProductVideoPlacementToVideo');

        Route::get('/admin/services/products' , 'ProductsServicesController@getProductsByLanguageIdAndDates');
        Route::get('/admin/services/products/{id}' , 'ProductsServicesController@getProductInfo')->where('id','[0-9]+');

        // product option services
        Route::get('/admin/services/options/all/{id?}','ProductOptionsServicesController@getAll');
        Route::get('/admin/services/options/info/{id}' , 'ProductOptionsServicesController@getProductOptionsInfo')->where('id','[0-9]+');

        // promos
        Route::get('/admin/promos','PromosController@index');
        Route::get('/admin/promos/add','PromosController@add');
        Route::post('/admin/promos/add','PromosController@postAdd');
        Route::get('/admin/promos/{id}/edit', 'PromosController@edit');
        Route::post('/admin/promos/{id}/edit', 'PromosController@postEdit');
        Route::post('/admin/promos/{id}/delete','PromosController@delete');

        Route::get('/admin/services/products/options','ProductOptionsServicesController@getAll');
        Route::post('/admin/services/promos/products/{id}/delete','PromosController@deletePromoProduct')->where('id','[0-9]+');

        // promo types
        Route::get('/admin/promos/types','PromoTypesController@index');
        Route::get('/admin/promos/types/add','PromoTypesController@add');
        Route::post('/admin/promos/types/add','PromoTypesController@postAdd');
        Route::get('/admin/promos/types/{id}/edit', 'PromoTypesController@edit');
        Route::post('/admin/promos/types/{id}/edit', 'PromoTypesController@postEdit');
        Route::post('/admin/promos/types/{id}/delete','PromoTypesController@delete');

        Route::get('/admin/services/promos','PromosServiceController@getPromos');

        // reviews
        Route::get('/admin/reviews/','ReviewsController@index');
        Route::get('/admin/reviews/add','ReviewsController@add');
        Route::post('/admin/reviews/add','ReviewsController@postAdd');
        Route::get('/admin/reviews/{id}/edit', 'ReviewsController@edit');
        Route::post('/admin/reviews/{id}/edit', 'ReviewsController@postEdit');
        Route::post('/admin/reviews/{id}/delete','ReviewsController@delete');

        // review sources
        Route::get('/admin/reviews/sources','ReviewSourcesController@index');
        Route::get('/admin/reviews/sources/add','ReviewSourcesController@add');
        Route::post('/admin/reviews/sources/add','ReviewSourcesController@postAdd');
        Route::get('/admin/reviews/sources/{id}/edit', 'ReviewSourcesController@edit');
        Route::post('/admin/reviews/sources/{id}/edit', 'ReviewSourcesController@postEdit');
        Route::post('/admin/reviews/sources/{id}/delete','ReviewSourcesController@delete');

        // currency
        Route::get('/admin/currency','CurrencyController@index');
        Route::get('/admin/currency/add','CurrencyController@add');
        Route::post('/admin/currency/add','CurrencyController@postAdd');
        Route::get('/admin/currency/{id}/edit', 'CurrencyController@edit');
        Route::post('/admin/currency/{id}/edit', 'CurrencyController@postEdit');
        Route::post('/admin/currency/{id}/delete','CurrencyController@delete');


        // languages
        Route::get('/admin/languages','LanguagesController@index');
        Route::get('/admin/languages/add','LanguagesController@add');
        Route::post('/admin/languages/add','LanguagesController@postAdd');
        Route::get('/admin/languages/{id}/edit', 'LanguagesController@edit');
        Route::post('/admin/languages/{id}/edit', 'LanguagesController@postEdit');
        Route::post('/admin/languages/{id}/delete','LanguagesController@delete');

        // departure city
        Route::get('/admin/departure-city','DepartureCityController@index');
        Route::get('/admin/departure-city/add','DepartureCityController@add');
        Route::post('/admin/departure-city/add','DepartureCityController@postAdd');
        Route::get('/admin/departure-city/{id}/edit', 'DepartureCityController@edit');
        Route::post('/admin/departure-city/{id}/edit', 'DepartureCityController@postEdit');
        Route::post('/admin/departure-city/{id}/delete','DepartureCityController@delete');

        // bookings
        Route::get('/admin/bookings','BookingsController@index');
        Route::post('/admin/bookings/search','BookingsController@search');
        Route::get('/admin/bookings/add','BookingsController@add');
        Route::post('/admin/bookings/add','BookingsController@postAdd');
        Route::get('/admin/bookings/{id}/edit', 'BookingsController@edit');
        Route::post('/admin/bookings/{id}/edit', 'BookingsController@postEdit');
        Route::post('/admin/bookings/{id}/delete','BookingsController@delete');
        Route::get('/admin/bookings/search', 'BookingsController@search');
        Route::get('/admin/bookings/{id}/voucher/print', 'BookingsController@getPrintVoucher');
        Route::get('/admin/bookings/{id}/voucher/email', 'BookingsController@getEmailVoucher');
        
        Route::get('/admin/source/list','SourceController@index');
        Route::get('/admin/source/add','SourceController@add');
        Route::post('/admin/source/add','SourceController@postAdd');
        Route::get('/admin/source/{id}/edit', 'SourceController@edit');
        Route::post('/admin/source/{id}/edit', 'SourceController@postEdit');
        Route::post('/admin/source/{id}/delete', 'SourceController@delete');
        Route::post('/admin/source/save_option', 'SourceController@save_option');
        Route::post('/admin/source/deleteOption', 'SourceController@deleteOption');

        Route::post('/admin/services/bookings/search/apply' , 'BookingServicesController@applyAction');
        Route::get('/admin/services/bookings/download', 'BookingServicesController@exportToExcel');

        Route::post('/admin/services/bookings/addons/{id}/delete','BookingServicesController@deleteAddon')->where('id','[0-9]+');
        Route::post('/admin/services/bookings/comments/{id}/delete','BookingServicesController@deleteComment')->where('id','[0-9]+');
        Route::post('/admin/services/bookings/clients/{id}/delete','BookingServicesController@deleteClient')->where('id','[0-9]+');
        Route::post('/admin/services/bookings/{id}/cancel','BookingServicesController@cancelBooking')->where('id','[0-9]+');
        Route::post('/admin/services/bookings/{id}/refund','BookingServicesController@cancelRefundBooking')->where('id','[0-9]+');
        Route::post('/admin/services/bookings/{id}/sendfeedback','BookingServicesController@sendFeedbackRequest')->where('id','[0-9]+');
        Route::get('/admin/services/bookings/getdetails','BookingServicesController@getBookingDetails');

        Route::get('/admin/services/bookings/compute/tourprice','BookingServicesController@computeTourPrice');
        Route::get('/admin/services/bookings/compute/addonprice','BookingServicesController@computeAddonPrice');
        Route::get('/admin/services/bookings/compute/totalprice','BookingServicesController@computeTotalPrice');

        Route::post('/admin/services/bookings/guide/assign','BookingServicesController@assignGuide');

        Route::get('/admin/services/bookings/validate-date','BookingServicesController@validateDate');

        // tour fees
        Route::get('/admin/tour-fees','TourFeesController@index');
        Route::get('/admin/tour-fees/add','TourFeesController@add');
        Route::post('/admin/tour-fees/add','TourFeesController@postAdd');
        Route::get('/admin/tour-fees/{id}/edit', 'TourFeesController@edit');
        Route::post('/admin/tour-fees/{id}/edit', 'TourFeesController@postEdit');
        Route::post('/admin/tour-fees/{id}/delete','TourFeesController@delete');

        // categories
        Route::get('/admin/categories','CategoriesController@index');
        Route::get('/admin/categories/add','CategoriesController@add');
        Route::post('/admin/categories/add','CategoriesController@postAdd');
        Route::get('/admin/categories/{id}/edit', 'CategoriesController@edit');
        Route::post('/admin/categories/{id}/edit', 'CategoriesController@postEdit');
        Route::post('/admin/categories/{id}/delete','CategoriesController@delete');

        // addons
        Route::get('/admin/addons','AddonsController@index');
        Route::get('/admin/addons/add','AddonsController@add');
        Route::post('/admin/addons/add','AddonsController@postAdd');
        Route::get('/admin/addons/{id}/edit', 'AddonsController@edit');
        Route::post('/admin/addons/{id}/edit', 'AddonsController@postEdit');
        Route::post('/admin/addons/{id}/delete','AddonsController@delete');

        Route::get('/admin/services/addons','AddonsServicesController@getAddons');
        Route::get('/admin/services/addons/{id}','AddonsServicesController@getAddon');
        Route::get('/admin/services/payment-methods','PaymentMethodsServicesController@getPaymentMethods');
        Route::get('/admin/services/addons/childprice','AddonsServicesController@getAddonChildPrice');

        Route::get('/admin/services/addons/promos/all','AddonsServicesController@getAddonPromos');

        // orders
        Route::get('/admin/orders','OrdersController@index');
        Route::get('/admin/orders/add','OrdersController@add');
        Route::post('/admin/orders/add','OrdersController@postAdd');
        Route::get('/admin/orders/{id}/edit', 'OrdersController@edit');
        Route::post('/admin/orders/{id}/edit', 'OrdersController@postEdit');
        Route::post('/admin/orders/{id}/delete','OrdersController@delete');
        Route::get('/admin/orders/{id}/bookings', 'OrdersController@viewBookings');

        // feedback emails
        Route::get('/admin/feedback-emails','FeedbackEmailsController@index');
        Route::get('/admin/feedback-emails/add','FeedbackEmailsController@add');
        Route::post('/admin/feedback-emails/add','FeedbackEmailsController@postAdd');
        Route::get('/admin/feedback-emails/{id}/edit', 'FeedbackEmailsController@edit');
        Route::post('/admin/feedback-emails/{id}/edit', 'FeedbackEmailsController@postEdit');
        Route::post('/admin/feedback-emails/{id}/delete','FeedbackEmailsController@delete');

        // faqs
        Route::get('/admin/faqs','FaqsController@index');
        Route::get('/admin/faqs/add','FaqsController@add');
        Route::post('/admin/faqs/add','FaqsController@postAdd');
        Route::get('/admin/faqs/{id}/edit', 'FaqsController@edit');
        Route::post('/admin/faqs/{id}/edit', 'FaqsController@postEdit');
        Route::post('/admin/faqs/{id}/delete','FaqsController@delete');

        // Admin Voucher Routes
        Route::get("/admin/vouchers", "VouchersController@index");
        Route::get("/admin/vouchers/add", "VouchersController@getAddVoucher");
        Route::post("/admin/vouchers/add", "VouchersController@postAddVoucher");
        Route::get("/admin/vouchers/edit/{id}", "VouchersController@getEditVoucher");
        Route::post("/admin/vouchers/edit/{id}", "VouchersController@postEditVoucher");
        Route::get("/admin/vouchers/delete/{id}", "VouchersController@getDeleteVoucher");
        Route::get("/admin/vouchers/preview/{id}", "VouchersController@getVoucherPreview");

    });

});


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


