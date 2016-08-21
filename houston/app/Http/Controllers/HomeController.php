<?php namespace App\Http\Controllers;

use App;
use Carbon\Carbon;
use App\Product;
use App\Review;
use App\Newsletter;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}


	/**
	 * just for troubleshooting
	 *
	 * @return void
	 */
	public function getTest(\Illuminate\Mail\Mailer $mail) {
		$sent = $mail->send(array(), array(), function($message) {
            $message->replyTo("booking@ecoarttravel.com", "EcoArt Travel");
            $message->from("booking@ecoarttravel.com", "EcoArt Travel");
            
            $message->to("a2zbits@gmail.com")->subject("Email Testing: ".time());

            $html = "
            	<html>
            		<body>
            			<p>If you are seeing this email that means the email TLS issue is fixed.</p>
            		</body>
            	</html>
            ";
            $message->setBody($html, "text/html");
        });
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		// first get locale
        $locale = App::getLocale();

		$products = Product::has("language_details")
							->with("departureCityDetails", "language_details")
							->where("product_type_id", 2)
							->orderBy("sort", "ASC")
							->limit(11)
							->get();

		$tickets = Product::has("language_details")
							->with("departureCityDetails", "language_details")
							->where("product_type_id", 1)
							->orderBy("sort", "ASC")
							->limit(11)
							->get();

		$transfers = Product::has("language_details")
							->with("departureCityDetails", "language_details")
							->where("product_type_id", 3)
							->orderBy("sort", "ASC")
							->limit(11)
							->get();

		$reviews = Review::where("flag_show", 1)->limit(2)->orderBy("id", "DESC")->get();

		return view('index', compact("locale", "products", "tickets", "transfers", "reviews"));

	}
	
	public function about()
	{
		return view('about.index');
	}

	public function getSendContactEmail(\Illuminate\Http\Request $request, \Illuminate\Mail\Mailer $mail){
		try{
			// sleep(2);
			$sent = $mail->send('emails.contact', array(
					"name" => $request->get("name"),
					"email" => $request->get("email"),
					"userMessage" => $request->get("message")
				), function($message) use ($request){
					$message->replyTo($request->get("email"), $request->get("name"));
				    $message->to('info@ecoarttravel.com', 'EcoArt Travel')->subject($request->get("name") . " sent you a message");
				});
			return response()->json(array(
				"success" => true,
				"message" => "Grazie! You e-mail has been sent and we’re already working on sending you a quick and helpful response. Can’t wait? Give us a call at +39 06 775 918 22 or Toll Free (Italy) 800 25 00 77 to speak to someone right away.",
				));
		}catch(\Exception $e){
			return response()->json(array(
				"success" => false,
				"message" => "Unable to send email, Please try again",
				"error" => $e->getMessage()
				));
		}
	}

	public function postSubscribeNewsletter(){
		$website = ltrim(url(), "http://");
		if(Input::get("email")){
			$data = Input::all();
			$data["website"] = $website;
			$validator = Validator::make($data, Newsletter::$rules, array(
				"email.unique" => "You have already subscribed",
				));
			if($validator->fails()){
				$messages = $messages = $validator->messages();
				$message = "<ul>";
				foreach ($messages->all("<li>:message</li>") as $key => $value) {
					$message .= $value;
				}
				$message .= "</ul>";
				return response()->json(array(
					"success" => false,
					"message" => $message,
					"error" => $messages
				));
			}
			$newsletter = new Newsletter;
			$newsletter->website = $website;
			$newsletter->email = Input::get("email");
			if($newsletter->save()){
				return response()->json(array(
					"success" => true,
					"message" => "You have successfully subscribed to our newsletter",
					));
			}
		}
		return response()->json(array(
			"success" => false,
			"message" => "Something went wrong, Please try again",
			"error" => ""
		));
	}

}
