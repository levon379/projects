<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//$route['default_controller'] = "welcome";
//$route['default_controller'] = "under_construnction";
$route['default_controller'] = "home";
$route['404_override'] = '';
$route['admin'] = "admin/login";
//routing properties
$route['properties/(:any)'] = "properties/index/$1";
//routing bungalows
$route['bungalows/(:any)'] = "bungalows/index/$1";
//routing gallery
$route['gallery/(:any)'] = "gallery/index/$1";
//routing trip-adviser
$route['trip-advisor'] = "trip_advisor";
//routing contact-us
$route['contact-us'] = "contact_us";
//routing rental-car
$route['rental-car'] = "rental_car";
//routing our-residence
$route['our-residence'] = "our_residence";
//routing contact-us
$route['about-st-martin'] = "about_st_martin";
//routing testimonials
$route['testimonials/(:any)'] = "testimonials/index/$1";
//routing reservation
//$route['reservation/(:any)'] = "reservation/index/$1";
$route['reservation/success'] = "reservation/success";
$route['reservation/paypal_cancel'] = "reservation/paypal_cancel";
$route['reservation/paypal_success'] = "reservation/paypal_success";
$route['reservation/on_arrival_payment/(:any)'] = "reservation/on_arrival_payment/$1";
$route['reservation/paypal_payment/(:any)'] = "reservation/paypal_payment/$1";
$route['reservation/payment_process'] = "reservation/payment_process";
$route['reservation/payment'] = "reservation/payment";
$route['reservation/reservation_process'] = "reservation/reservation_process";
$route['reservation/ajax_check_availability'] = "reservation/ajax_check_availability";
$route['reservation/ajax_get_options'] = "reservation/ajax_get_options";
$route['reservation/ajax_set_registration_session'] = "reservation/ajax_set_registration_session";
$route['reservation/ajax_unset_registration_session'] = "reservation/ajax_unset_registration_session";
$route['reservation/get_max_person'] = "reservation/get_max_person";
$route['reservation/(:any)'] = "reservation/index/$1";

//routing news
$route['activity/(:any)'] = "activity/index/$1";

$route['contact-us/success'] = "contact_us/success";

/* End of file routes.php */
/* Location: ./application/config/routes.php */