<?php namespace App\Http\Controllers;

use App\Libraries\Helpers;
use App\Faq;
use App\FaqsProduct;
use App\FaqsWebsite;
use App\Language;
use App\Product;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Validator;

class FaqsController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
        $faqs = Faq::all();
		$languages = Language::all();
        return view('faqs.index',compact('faqs', 'languages'));
    }

    public function add(){
        $mode = 'add';
        $faqs = Faq::all();
		$languages = Language::all();
		
		$products = Product::all();
		
        return view('faqs.add_edit',compact('faqs', 'languages', 'mode', 'products'));
    }

    public function postAdd(){
        $languageId 		= Input::get('language_id');
        $question 			= Input::get('question');
        $answer 	       = Input::get('answer');
        
		$product_ids        = Input::get('products');
        $website_ids        = Input::get('websites');

        $faq = new Faq;
		$faq->language_id 		    = $languageId;
        $faq->question 				= $question;
        $faq->answer                = $answer;
        
        $input = Input::all();

        $rules = array(
            'question'              => 'required',
            'answer'                => 'required',
            'language_id'           => 'required'
        );

        
        $validation = Validator::make($input, $rules);

        if($validation->passes()){


            $faq->save();

            if($faq->id){
			
				if(!empty($website_ids)){
					$faq->websites()->attach(explode(",",$website_ids));
                }

                if(!empty($product_ids)){
                    $faq->products()->attach(explode(",",$product_ids));
                }
				
                return redirect("/admin/faqs/")
                    ->with('success',' <b>FAQ</b> successfully added');
            }
        }

        return redirect("/admin/faqs/add")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $mode = 'edit';
        $faq = Faq::find($id);
        $faqs = Faq::all();
		$languages = Language::all();
        $products = Product::all();
        
        $websites = $faq->websites->lists('id');
        $website_selection = implode(",",$websites);

        $products = $faq->products->lists('id');
        $product_selection = implode(",",$products);
		
		return view('faqs.add_edit',
            compact('faq', 'faqs', 'languages', 'website_selection', 'product_selection', 'mode', 'products'));
    }

    public function postEdit($id){

        $languageId         = Input::get('language_id');
        $question           = Input::get('question');
        $answer            = Input::get('answer');
        
        $product_ids        = Input::get('products');
        $website_ids        = Input::get('websites');

        $faq = Faq::find($id);
        $faq->language_id           = $languageId;
        $faq->question              = $question;
        $faq->answer                = $answer;
        
        $rules = array(
            'question'              => 'required',
            'answer'                => 'required',
            'language_id'           => 'required'
        );

        $input = Input::all();


        $validation = Validator::make($input, $rules);

        if($validation->passes()){
			
			// attach website Ids
            if(!empty($website_ids)){
                $website_ids_old_array = $faq->websites->lists('id');

                $website_ids = explode(",",$website_ids);

                $website_ids_old = array_diff($website_ids_old_array, $website_ids);

                if(!empty($website_ids_old)){
                    $faq->websites()->detach($website_ids_old);
                }

                $website_ids_new = array_diff($website_ids, $website_ids_old_array);

                if(!empty($website_ids_new)){
                    $faq->websites()->attach($website_ids_new);
                }
            } else {

                if(count($faq->websites)>0){
                    $faq->websites()->detach();
                }

            }

            // attach product Ids
            if(!empty($product_ids)){
                $product_ids_old_array = $faq->products->lists('id');

                $product_ids = explode(",",$product_ids);

                $product_ids_old = array_diff($product_ids_old_array, $product_ids);

                if(!empty($product_ids_old)){
                    $faq->products()->detach($product_ids_old);
                }

                $product_ids_new = array_diff($product_ids, $product_ids_old_array);

                if(!empty($product_ids_new)){
                    $faq->products()->attach($product_ids_new);
                }
            } else {

                if(count($faq->products)>0){
                    $faq->products()->detach();
                }

            }

            
            $faq->save();
			
			$faqLink = "<a href='/admin/faqs/$id/edit'>FAQ</a>";

            if($faq->id){
                return redirect("/admin/faqs/")
                    ->with('success'," <b>$faqLink</b> successfully updated");
            }
        }

        return redirect("/admin/faqs/$id/edit")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $faq = Faq::find($id);
        $question = $faq->question;

        try {

            $faq->websites()->detach();
            $faq->products()->detach();
            $faq->delete();

        } catch (QueryException $e) {

            return redirect('/admin/faqs')->with("error","<b>FAQ</b> cannot be deleted it is being used by the system");

        }

        return redirect('/admin/faqs')->with("success","<b>FAQ</b> has been deleted successfully");

    }

}