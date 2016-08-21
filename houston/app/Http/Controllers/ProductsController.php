<?php namespace App\Http\Controllers;

use App\Libraries\Helpers;
use App;
use App\Product;
use App\ProductOption;
use App\ProductLanguageDetail;
use App\Language;
use App\Category;

use App\DepartureCity;
use App\DepartureCityLanguageDetail;
use App\CategoryLanguageDetail;
use Validator;
use Illuminate\Support\Facades\Request;

use App\Libraries\Repositories\ProductsRepository;
use App\Libraries\Repositories\BookingsRepository;

use \Illuminate\Support\Facades\Config;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;



class ProductsController extends Controller {

	public function __construct( ProductsRepository $productsRepository, BookingsRepository $bookingsRepository )
	{
		//$this->middleware('auth');
		$this->productsRepository = $productsRepository;
		$this->bookingsRepository = $bookingsRepository;
	}

	public function index($cityOrCatSlug)
	{
        // init
        $cityId = 0;
        $catId = 0;
        $whichPage = '';
        $productsQry = null;

        // init search params
        $city = Input::get('city');
        $sCategories = Input::get('sCategories');
        $sortBy = Input::get('sortBy');
        $sortOrder = Input::get('sortOrder');
        $sArrivalDate = Input::get('sArrivalDate');
        $sDepartureDate = Input::get('sDepartureDate');

        $arrivalDateCarbon = ($sArrivalDate && !empty($sArrivalDate)) ? Carbon::createFromFormat( 'd/m/Y', $sArrivalDate ) : null;
        $departureDateCarbon = ($sDepartureDate && !empty($sDepartureDate)) ? Carbon::createFromFormat( 'd/m/Y', $sDepartureDate ) : null;

        // first get locale
        $locale = App::getLocale();

        // get langId
        $language = Language::whereCode( $locale )->first();
        $langId = $language->id;

        // now check if we need to show CityPage or CategoryPage

        // check if $cityOrCatSlug is a CitySlug
        $cityDetail = DepartureCityLanguageDetail::whereLanguageId( $langId )
                    ->whereSlug( $cityOrCatSlug )
                    ->first();

        $metaData = DepartureCityLanguageDetail::getMetaData($cityOrCatSlug);
        // dd($cityDetail->toArray(), $cityDetail->getMetaData());
        // check if $cityOrCatSlug is a CitySlug but an additional url is passed
        if(!empty($cityDetail))
        {
            $whichPage = 'CityPage';
            $productsQry = $cityDetail->departureCity->products();
        }

        // if $cityOrCatSlug was not CitySlug then check if it is CategorySlug
        if( empty($cityDetail) )
        {
            // check if $cityOrCatSlug is a CategorySlug
            $catDetail = CategoryLanguageDetail::whereLanguageId( $langId )
                        ->whereSlug( $cityOrCatSlug )
                        ->first();

            // check if $cityOrCatSlug is neither a CitySlug and nor a CatSlug then discard
            if( empty($catDetail) )
            {
                // someone has altered url. just discard it
                App::abort(404);
            }
            else
            {
                $whichPage = 'CategoryPage';
                $catId = $catDetail->category_id;

                if( !empty($sCategories) )
                {
                    $productsQry = Product::whereRaw('1');
                    //$sCategories = $catId;

                }
                else
                {
                    $productsQry = $catDetail->category->products();
                }
            }

        }

        if( $catId > 0 and empty($sCategories) )
        {
            $sCategories = $catId;
        }

        if( $sCategories == "all" )
        {
            // do nothing
        }
        elseif( !empty($sCategories) )
        {
            // add a where Clause
            $productsQry->whereHas('categories', function($q) use($sCategories) {
                $categories = explode(',', $sCategories);
                $q->whereIn('category_id', $categories);
            });
        }
        elseif( $catId > 0 )
        {
            // add a where Clause
            $productsQry->whereHas('categories', function($q) use($catId) {
                $q->whereCategoryId( $catId );
            });
        }

        // now we have productIds either from city or from cateogry.

        if( $arrivalDateCarbon or $departureDateCarbon )
        {
        
            $productsQry->whereHas('options', function($q) use( $arrivalDateCarbon, $departureDateCarbon )
            {

                // add start date if specified by end user
                if( $arrivalDateCarbon ) {
                    $q->where(function($q) use($arrivalDateCarbon) {
                        $q->where('trav_season_start', '<=', $arrivalDateCarbon->toDateString());
                        $q->orWhere('trav_season_start', '=', '0000-00-00');
                    });
                }

                // add end date if specified by end user
                if( $departureDateCarbon )
                {
                    $q->where(function($q) use($departureDateCarbon) {
                        $q->where('trav_season_end', '>=', $departureDateCarbon->toDateString());
                        $q->orWhere('trav_season_end', '=', '0000-00-00');
                    });
                }

            });

        }
        
        
        // fetch ProductLanguageDetails against productIds
        $productsQry->with([
                'languageDetail' => function($q) use ($langId) {
                    $q->whereLanguageId( $langId );
                },
                'averageRating',
                'reviewsCount' => function($q) {
                    $q->whereFlagShow(1);
                },
                'city.languageDetail' => function($q) use($langId) {
                    $q->whereLanguageId($langId);
                }
            ])->whereHas(
                'languageDetail',
                function($q) use ($langId) {
                    $q->whereLanguageId( $langId );
                }
            );

        // set sort order 
        if( $sortBy == "price" )
        {
            $productsQry->orderBy('default_price', $sortOrder);
        }
        elseif( $sortBy == "rating" )
        {
            $productsQry->select('products.*')
                ->leftJoin( 'reviews', 'products.id', '=', 'reviews.product_id')
                ->orderBy(DB::raw('avg(reviews.rating)'), 'DESC')
                ->groupBy('products.id');
        }

        $products = $productsQry->get();
        
        //dd($products->toArray(), \DB::getQueryLog());
        
        // get all categories based on filter

        $categories = Category::with('products.options')
            ->whereHas('products.options', function($q) use( $arrivalDateCarbon, $departureDateCarbon )
            {
                // add start date if specified by end user
                if( $arrivalDateCarbon ) {
                    $q->where(function($q) use($arrivalDateCarbon) {
                        $q->where('trav_season_start', '<=', $arrivalDateCarbon->toDateString());
                        $q->orWhere('trav_season_start', '=', '0000-00-00');
                    });
                }

                // add end date if specified by end user
                if( $departureDateCarbon )
                {
                    $q->where(function($q) use($departureDateCarbon) {
                        $q->where('trav_season_end', '>=', $departureDateCarbon->toDateString());
                        $q->orWhere('trav_season_end', '=', '0000-00-00');
                    });
                }
            })
            ->whereHas(
                'products.languageDetail',
                function($q) use ($langId) {
                    $q->whereLanguageId( $langId );
                })
            ->get();

        // $product = Product::find(7);
        // dd($product->getImage(1)->toArray());
            
        //dd($categories->toArray(), \DB::getQueryLog());
        //dd($products->toArray());
		return view('products.index', compact(
            'locale', 'products', 'whichPage', 'categories',
            'sDepartureDate', 'sArrivalDate', 'sortOrder', 'sortBy', 'sCategories', 'metaData'
            ));
	}
	
	public function viewProduct($citySlug, $productUrl)
	{
		// init
        $cityId = 0;
        
        // first get locale
        $locale = App::getLocale();

        // get langId
        $language = Language::whereCode( $locale )->first();
        $langId = $language->id;

        // now check if we need to show CityPage or CategoryPage

        // check if $citySlug is a CitySlug
        $cityDetail = DepartureCityLanguageDetail::whereLanguageId( $langId )
                    ->whereSlug( $citySlug )
                    ->first();

        // check if $citySlug is a CitySlug but an additional url is passed
        if(empty($cityDetail))
        {
            App::abort(404);
        }

        // check if $productUrl is a Product URL in languageDetail table
        $product = Product::with('languageDetail')
                        ->whereHas('languageDetail', function( $q ) use( $productUrl, $langId ) {
                            $q->whereUrl( $productUrl );
                            $q->whereLanguageId( $langId );
                        })->first();

        // check if $cityOrCatSlug is a CitySlug but an additional url is passed
        if(empty($product))
        {
            App::abort(404);
        }

        //dd($product->toArray());

		if($product){

            $languageOffDates = $product->getOptionsCommonLanguageUnavailableDays();
            $optionOffDates = $product->getOptionsCommonUnavailableDays();
            $offDates = array_merge($languageOffDates, $optionOffDates);

			// fetch languages to display in language dropdown form
            $languages = $this->productsRepository->getProductLanguages($product);

            // fetch FAQs against this product and language
            $faqs =  $product->faqs()->whereLanguageId( $langId )->get();

            // fetch reviews against this product and language.
            // list reviews from all languages but list those 1st where languageId matches.
            $priorityStr = DB::raw("(CASE WHEN language_id = '$langId' THEN 0 ELSE 1 END) as priority");
            $reviews =  $product->reviews()->with('source')
                        ->select('*', $priorityStr)
                        ->whereFlagShow(1)
                        ->orderBy('priority')
                        ->get();

            // fetch latest 2 reviews against this product and language to display in right side review panel
            // list reviews from all languages but list those 1st where languageId matches.
            $priorityStr = DB::raw("(CASE WHEN language_id = '$langId' THEN 0 ELSE 1 END) as priority");
            $latestReviews =  $product->reviews()->with('source')
                        ->select('*', $priorityStr)
                        ->whereFlagShow(1)
                        ->orderBy('priority')
                        ->orderBy('created_at', 'DESC')
                        ->limit(2)
                        ->get();

            // get average star rating against produt to display in right column
            $productRating = $product->reviews()->whereFlagShow(1)->avg('rating');

            // get product videos
            $videos = $product->videos;

            if( count($videos) > 0 )
            {
                foreach($videos as &$video) {
                    $video->itemType = "video";
                }

                $videos = $videos->toArray();
            }
            else
            {
                $videos = [];
            }

            // get product images where site is ecoarttravel.com
            // $images = $product->images()->whereHas('websites', function($q){
            //     return $q->where('websites.id', '=', 1);
            // })->get();

            $images = $product->getImages( Config::get('constants.PRODUCT_DETAIL_GALLERY_FULL_IMAGE') );
            

            if( count($images) > 0 )
            {
                $images =  $images->toArray();
            }
            else
            {
                $images = [];
            }

            $images = array_merge( $videos, $images );

            $imageCount = count($images);

            // create chunks on the basis of number of images per page in gallery carousel
            $imageChunks = array_chunk($images, 6);

            foreach( $imageChunks as &$chunk )
            {
                $chunk = array_chunk($chunk, 3);
            }

            // fetch the recommended products to display in right panel
            $recommendedProducts = $product->recommendedProducts()
                                    ->with(['languageDetail' => function($q) use($langId) {
                                        $q->whereLanguageId( $langId );
                                    },
                                    'averageRating', 'reviewsCount' ])
                                    ->take(2)
                                    ->orderBy('id', 'DESC')
                                    ->get();
            
            $today = Carbon::today();
            
            $seasonStartDate = Carbon::createFromFormat(
                "Y-m-d", 
                $product->options()
                        ->where("flag_show", 1)
                        ->min("trav_season_start"))->setTime(0,0,0);
            //dd($seasonStartDate);
            
            if( $today->lt( $seasonStartDate ) )
            {
                $calendarStartDate = $seasonStartDate;
            }
            else
            {
                $calendarStartDate = $today;
                $calendarStartDate->addDays(1);
                
            }
            

            $strSeasonEndDateMin = $product->options()->where("flag_show", 1)->min("trav_season_end");
            $strSeasonEndDateMax = $product->options()->where("flag_show", 1)->max("trav_season_end");
            //dd($strSeasonEndDateMax);
            $calendarEndDate = null;

            if($strSeasonEndDateMin != '0000-00-00' and $strSeasonEndDateMax != '0000-00-00')
            {
                $seasonEndDate = Carbon::createFromFormat(
                                    "Y-m-d", 
                                    $product->options()
                                            ->where("flag_show", 1)
                                            ->max("trav_season_end")
                                )->setTime(0,0,0);
                $calendarEndDate = $seasonEndDate->gt($calendarStartDate) ? $seasonEndDate : $calendarStartDate;
                //dd($calendarEndDate);
            }

            // calculate common OFF runningDays
            $runningDays = $product->runningDays; // string like 1010101
            $runningDays = decbin(bindec($runningDays) ^ bindec('1111111'));   //invert the bits like 0101010
            $runningDays = str_pad($runningDays, 7, 0, STR_PAD_LEFT); // str-pad zeros on left if length < 7
            
            $runningDaysArr = str_split($runningDays); // str to array

            $daysNumbers = [1,2,3,4,5,6,0];
            $disabledCalendarDays = [];

            foreach($runningDaysArr as $key => $runningDay)
            {
                if($runningDay == 1)
                {
                    $disabledCalendarDays[] = $daysNumbers[$key];
                }
            }

            $calendarStartDate = $this->getFirstAvailableDate( $calendarStartDate, $calendarEndDate, $disabledCalendarDays, $offDates );

            //dd($calendarStartDate);

            return view(
                'products.view',
                compact(
                    'product', 'languages', 'langId', 'citySlug',
                    'faqs', 'reviews', 'productRating', 'imageChunks',
                    'imageCount', 'latestReviews', 'recommendedProducts',
                    'calendarStartDate', 'calendarEndDate', 'disabledCalendarDays', 'offDates'
                    )
                );
        }

	}

    public function getFirstAvailableDate( $calendarStartDate, $calendarEndDate, $disabledCalendarDays, $offDates ) 
    {
        $count = 0; // loop max 365 days
        while ( $count <= 365 and (is_null($calendarEndDate) or $calendarStartDate->lte( $calendarEndDate ) ) )
        {
            //echo $calendarStartDate." = ".$calendarEndDate."<br>";
            if( $this->isOffDate($calendarStartDate, $disabledCalendarDays, $offDates) )
            {
                $calendarStartDate->addDays(1);
            }
            else
            {
                return $calendarStartDate;
            }

            $count++;
        }

        return null;
           
    }

    public function isOffDate($date, $disabledCalendarDays, $offDates)
    {
        if( in_array($date->toDateString(), $offDates) )
        {
            return true;
        }
        elseif( in_array($date->dayOfWeek, $disabledCalendarDays) )
        {
            return true;
        }
        else
        {
            return false;
        }


    }

	public function book($id)
	{
		$input = Input::all();

		$rules = array(

            'product_option_id' => 'required',
            'no_adult' => 'required|at_least:1',
            'travel_date' => 'required',
            'language_id' => 'required'
        );

        $messages = array(
            'product_option_id.required' => 'Please choose a product option',
            'language.required' => 'Please choose a language',
            'no_adult.required' => 'There should be at least 1 adult',
            'no_adult.at_least' => 'There should be at least 1 adult',
            'travel_date.required' => 'This travel date field is required',
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){

        	$productOptionId = Input::get('product_option_id');
			$option = ProductOption::find( $productOptionId );
			$adultNo = Input::get('no_adult');
			$childNo = Input::get('no_children');
            $langId = Input::get('language_id');
			$travelDate = Carbon::createFromFormat('d/m/Y', Input::get('travel_date') )->toDateString();
			$promoId = null;

        	//Session::set('cart.products', []);
			if(!Session::has('cart'))
			{ 
				Session::set('cart.products', []);
				Session::set('cart.promo_code', null);
				Session::set('cart.promo_id', null);
				Session::set('cart.totalCartValue', 0);
			}

			$booking = new \stdClass();
			$booking->cartItemId = time(); // This must be unique
			$booking->productId = $option->product_id;
			$booking->bookingDate = Helpers::displayDateShort($travelDate);
			$booking->adult_no = $adultNo;
			$booking->child_no = $childNo;
			$booking->booking_id = null;
            $booking->language_id = $langId;

			$booking->product_option_id = $option ? $option->id : null;

			Session::push('cart.products', $booking);

			$currentCartValue = Session::get('cart.totalCartValue', 0);
			
			$newCartValue = $currentCartValue + $this->bookingsRepository->computeTourPrice( $productOptionId, $adultNo, $childNo, $promoId );
			Session::set('cart.totalCartValue', $newCartValue);

			return 'Success';
        }
        else 
        {
        	
        	return \View::make('products.errors')
        				->withErrors($validation);
        }
	}

    public function success(){
        return view('products.success');
    }

}
