<?php
class ContactUsController extends BaseController {

  /**-------------------------------------------------------------------------
  * main(): displays the contact-us page
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
	function index() {
		$user = User::getUserInfo(Auth::id());
		return View::make('contact-us')
			->with('pageData', $this->pageData)
			->with('user', $user)
			->with('view', 'index');
	} // main()

  /**-------------------------------------------------------------------------
  * submit(): contact us form submission
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
	function submit() {
		$userInfo = User::getUserInfo(Auth::id());

		/* Retrieve POST variables */
		$comment = Input::get('comment', '');
		
		/* Build the array that supports validating the post data */
		$validator_data = array( 
			'comment' => $comment,
		);

		$validator_rules = array( 
			'comment' => 'required',
		);

		/* Validate the post data */
		$validator = Validator::make($validator_data, $validator_rules);

		/* Go back if validation fails */
		if($validator->fails()) {	
			return Redirect::back()
        ->withErrors($validator)
        ->withInput();		
		}	

		/* Include submitted data in thank you screen and email*/
		$this->pageData['comment'] = nl2br($comment);

		/* By adding these vars to the emailData array, their details will be
       accessble in the email.view */
		$emailData['pageData'] = array($this->pageData);
		$emailData['userInfo'] = array($userInfo);	
		$emailData['Headline'] = "Mail Testing";

		/* if PRETEND is set, then display the email content instead */			
		if(Config::get('mail.pretend')) {
			return View::make('emails.bid-to-email')
				->with('emailData', $emailData);
		}
		
		/* email addresses - repeat additional 'toEmail' lines as needed */
		$toEmail[0] = (array('email' => $this->pageData['companyEmail'],
                       'name' => $this->pageData['companyName']));
		$toEmail[1] = (array('email' => 'pbechard@gmail.com', 'name' => 'Peter Bechard'));

		$fromEmail = array('email'=>$userInfo->email, 'name' => $userInfo->name);
		$subject = $this->pageData['companyName'].' - Contact Us - '.$userInfo->name;
		$attachments = array();  //$message->attach($pathToFile);

		/* $pageData and $userInfo are base as parameters to the mail tag */
		Mail::send('emails.contact-us-email', $emailData, 
      function($message) use ($toEmail, $fromEmail, $subject, $attachments) 
    {
			foreach($toEmail as $key => $value) {	
        $message->to($value['email'], $value['name']);
      }
			$message->from($fromEmail['email'], $fromEmail['name']);
			$message->subject($subject);
		});

		$emailStatusMessage = '';
		if(count(Mail::failures()) > 0) {
			echo "There was one or more failures. They were: <br>";
			foreach(Mail::failures() as $email_address) {
				$emailStatusMessage .= "Failed recipient: $email_address <br>";
			}
			return Redirect::back()
				->withErrors($emailStatusMessage)
				->with('messages', array($emailStatusMessage, $this->pageData['error']))
				->withInput();
		} 
    else {
			$emailStatusMessage="Your email has been successfully sent.";
		}

		return View::make('contact-us')
			->with('pageData', $this->pageData)
			->with('userInfo', $userInfo)
			->with('messages', array($emailStatusMessage, $this->pageData['success']))
			->with('view', 'thanks');
	} // submit()
} // class
?>

