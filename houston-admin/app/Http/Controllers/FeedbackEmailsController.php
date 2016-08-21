<?php namespace App\Http\Controllers;

use App\Libraries\Helpers;
use App\FeedbackEmail;
use App\Provider;
use App\Language;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Validator;

class FeedbackEmailsController extends Controller {

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function index(){
        $feedbackEmails = FeedbackEmail::all();
        return view('feedback_emails.index',compact('feedbackEmails'));
    }

    public function add(){
        $feedbackEmails = FeedbackEmail::all();
		$providers = Provider::all();
		$languages = Language::all();
        $mode = 'add';
        return view('feedback_emails.add_edit',compact('mode','feedbackEmails','providers','languages'));
    }

    public function postAdd(){
        $name = Input::get('name');
        $fromEmail = Input::get('from_email');
        $subject = Input::get('subject');
		$provider_id = Input::get('provider_id');
        $language_id = Input::get('language_id');
        $body = Input::get('body');
        $emailName = Input::get('email_name');

        $feedbackEmail = new FeedbackEmail;
        $feedbackEmail->name = $name;
        $feedbackEmail->from_email = $fromEmail;
        $feedbackEmail->subject = $subject;
		$feedbackEmail->provider_id = $provider_id;
		$feedbackEmail->language_id = $language_id;
        $feedbackEmail->body = $body;
        $feedbackEmail->email_name = $emailName;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
            'from_email' => 'required',
            'subject' => 'required' ,
            'body' => 'required',
            'email_name' => 'required'
        );

        $messages = array(
            'name.required' => 'The name field is required',
            'from_email.required' => 'The from email field is required',
            'subject.required' => 'The subject field is required',
            'body.required' => 'The body field is required',
            'email_name.required' => 'The email name field is required '
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $feedbackEmail->save();

            if($feedbackEmail->id){
                return redirect("/admin/feedback-emails")
                    ->with('success','Feedback email successfully added');
            }
        }

        return redirect("/admin/feedback-emails/add")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $feedbackEmails = FeedbackEmail::all();
        $feedbackEmail = FeedbackEmail::find($id);
		$providers = Provider::all();
		$languages = Language::all();
        $mode = 'edit';
        return view('feedback_emails.add_edit',compact('feedbackEmail','feedbackEmails','mode','providers','languages'));
    }

    public function postEdit($id){

        $name = Input::get('name');
        $fromEmail = Input::get('from_email');
        $subject = Input::get('subject');
		$provider_id = Input::get('provider_id');
        $language_id = Input::get('language_id');
        $body = Input::get('body');
        $emailName = Input::get('email_name');

        $feedbackEmail = FeedbackEmail::find($id);
        $feedbackEmail->name = $name;
        $feedbackEmail->from_email = $fromEmail;
        $feedbackEmail->subject = $subject;
		$feedbackEmail->provider_id = $provider_id;
		$feedbackEmail->language_id = $language_id;
        $feedbackEmail->body = $body;
        $feedbackEmail->email_name = $emailName;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
            'from_email' => 'required',
            'subject' => 'required' ,
            'body' => 'required',
            'email_name' => 'required'
        );

        $messages = array(
            'name.required' => 'The name field is required',
            'from_email.required' => 'The from email field is required',
            'subject.required' => 'The subject field is required',
            'body.required' => 'The body field is required',
            'email_name.required' => 'The email name field is required '
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){

            $feedbackEmail->save();

            if($feedbackEmail->id){
                return redirect("/admin/feedback-emails/")
                    ->with('success','Feedback email successfully updated');
            }
        }

        return redirect("/admin/feedback-emails/$id/edit")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $feedbackEmail = FeedbackEmail::find($id);
        $name = $feedbackEmail->name;

        try {
            $feedbackEmail->delete();
        } catch (QueryException $e) {
            return redirect('/admin/feedback-emails')->with("error","<b>$name</b> cannot be deleted it is being used by the system");
        }

        return redirect('/admin/feedback-emails')->with("success","<b>$name</b> has been deleted successfully");

    }
}