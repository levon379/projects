<?php namespace App\Http\Controllers;

use App\Review;
use App\ReviewSource;
use App\Booking;
use App\Product;
use App\Language;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Input;
use Validator;

class ReviewsController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
        $reviews = Review::paginate(10);
        return view('reviews.index',compact('reviews'));
    }

    public function add(){
        $mode = 'add';
        $reviewSources = ReviewSource::all();
		$bookings = Booking::all();
		$products = Product::all();
		$languages = Language::all();
		$shown = Input::old('flag_show_value', true);
        return view('reviews.add_edit',compact('reviewSources', 'bookings', 'products', 'languages', 'mode', 'shown'));
    }

    public function postAdd(){
		$title = Input::get('title');
		$languageId = Input::get('language_id');
		$reviewSourceId = Input::get('review_source_id');
		$bookingId = Input::get('booking_id');
		$productId = Input::get('product_id');
		$email = Input::get('email');
        $name = Input::get('name');
        $rating = Input::get('rating');
		$comment = Input::get('comment');
        $flagShow = Input::get('flag_show_value');

        $review = new Review;
		$review->title = $title;
		$review->language_id = $languageId;
        $review->review_source_id = $reviewSourceId;
        $review->booking_id = $bookingId ? $bookingId : null;
		$review->product_id = $productId;
        $review->email = $email;
        $review->name = $name;
        $review->rating = $rating;
        $review->comment = $comment;
        $review->flag_show = $flagShow;
		
        $input = Input::all();

        $rules = array(
			'product_id' => 'required',
            'name' => 'required',
            'rating' => 'required',
            'comment' => 'required',
			'email' => 'email',
			'title' => 'required'
        );

        $messages = array(
			'title.required' => 'The title field is required',
            'name.required' => 'This name field is required',
            'product_id.required' => 'The product field is required',
            'rating.required' => 'The rating field is required',
            'comment.required' => 'The comment field is required'
            
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $review->save();

            if($review->id){
                return redirect("/admin/reviews/")
                    ->with('success','Review successfully added');
            }
        }

        return redirect("/admin/reviews/add")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $mode = 'edit';
		$review = Review::find($id);
		$reviewSources = ReviewSource::all();
		$bookings = Booking::all();
		$languages = Language::all();
		$products = Product::all();
		$shown = Input::old('flag_show', ($review->flag_show));
        return view('reviews.add_edit',compact('review','reviewSources', 'bookings', 'products', 'languages', 'mode', 'shown'));
    }

    public function postEdit($id){
		$title = Input::get('title');
		$languageId = Input::get('language_id');
		$reviewSourceId = Input::get('review_source_id');
		$bookingId = Input::get('booking_id');
		$productId = Input::get('product_id');
		$email = Input::get('email');
        $name = Input::get('name');
        $rating = Input::get('rating');
		$comment = Input::get('comment');
        $flagShow = Input::get('flag_show_value');

        $review = Review::find($id);
		$review->title = $title;
		$review->language_id = $languageId;
        $review->review_source_id = $reviewSourceId;
        $review->booking_id = $bookingId ? $bookingId : null;
		$review->product_id = $productId;
        $review->email = $email;
        $review->name = $name;
        $review->rating = $rating;
        $review->comment = $comment;
        $review->flag_show = $flagShow;

        $input = Input::all();

        $rules = array(
			'product_id' => 'required',
            'name' => 'required',
            'rating' => 'required',
            'comment' => 'required',
			'email' => 'email',
			'title' => 'required'
        );

        $messages = array(
			'title.required' => 'The title field is required',
            'name.required' => 'This name field is required',
            'product_id.required' => 'The product field is required',
            'rating.required' => 'The rating field is required',
            'comment.required' => 'The comment field is required'
        );

	
        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $review->save();

            if($review->id){
                return redirect("/admin/reviews/")
                    ->with('success','Review successfully updated');
            }
        }

        return redirect("/admin/reviews/$id/edit")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $review = Review::find($id);
		$review->delete();
        return redirect('/admin/reviews')->with("success","<b>Review ID#$id </b> has been deleted successfully");

    }
}