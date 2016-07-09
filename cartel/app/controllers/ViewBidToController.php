<?php
class ViewBidToController extends BaseController {

  /**-------------------------------------------------------------------------
  * main(): displays a page to view a bid
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
	public function main($bid_id=0) {
    /* Is an existing bid, so establish product class to update */
		if(is_numeric($bid_id) && $bid_id>0) {	
			$bid_details = Bid::getBidInfo($bid_id);
			$bid = Bid::find($bid_id);
      $bid->bid_viewed = true;
      $bid->save();
			$product_details = Product::getProductInfo($bid_details->product_id);
		}
    /* Bid_id is invalid, */
		else {	
			return Redirect::to('/create-edit-a-post')
				->with('messages',
          array(Lang::get('site_content.post_to_Product_Not_Exist'),
                $this->pageData['error']));
		}

		if ($bid_details->bid_type == 'sell')
      $view_name = 'view-bid-to-sell';
		else
      $view_name = 'view-bid-to-buy';

		/* Create the view and pass it the data */
		return View::make($view_name)
			->with('pageData', $this->pageData)
			->with('bid_details', $bid_details)
			->with('product_details', $product_details);
	} // main()
		
  /**-------------------------------------------------------------------------
  * store(): 
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
	public function store($bid_id = 0) {
		/* Retrieve the common submitted variables */
		$decision = Input::get('decision', '');
		$password = Input::get('password');

		/* Check to see if the password is correct */
		$userInfo = User::find(Auth::id());
    
		if (!(Hash::check($password, $userInfo->password))) {
			$msg = Lang::get('site_content.global_Incorrect_Password');
			return Redirect::back()
				->withInput()
				->withErrors($msg);
		}

    /* Is an existing bid, so establish product class to update */
		if(is_numeric($bid_id) && $bid_id>0) {	
			$bidToSave = Bid::find($bid_id);
			$productToSave = Product::find($bidToSave->product_id);
			
			/* Check if bid is still waiting for a response (status_id=59) --*/
			if($bidToSave->status_id != 59) {
//				return Redirect::to('/create-edit-a-post')
//					->with('messages',
              //array(Lang::get('site_content.post_to_Product_Not_Exist'),
                    //$this->pageData['error']));
			}
		}
    /* Bid_id is invalid, */
		else {	
			return Redirect::to('/create-edit-a-post')
				->with('messages',
            array(Lang::get('site_content.post_to_Product_Not_Exist'),
                  $this->pageData['error']));
		}
			
		/* -----------------------------------------------*/
		/* if ACCEPT */	
		/* -----------------------------------------------*/
		if($decision == 'accept') {
			/* Update bid status to accepted, and capture accepter_id */	
			$bidToSave->accepter_id = Auth::id();
			$bidToSave->status_id = 60;
			$bidToSave->save();
			
			/* Insert entry into Order table */	
			$orderToSave                         = new Order;
			$orderToSave->locale_id              = $this->pageData['locale_id'];
			$orderToSave->language_id            = $this->pageData['language_id'];
			$orderToSave->accounting_number      = DB::table('order') ->max('accounting_number')+1;
			$orderToSave->bid_id                 = $bid_id;
			$orderToSave->bid_type               = $bidToSave->bid_type;
			$orderToSave->per_item_discount      = 0;
			$orderToSave->receivable_status_id   = 65;
			$orderToSave->payable_status_id      = 67;
			$orderToSave->shipped_qty            = 0;
			$orderToSave->received_qty           = 0;
			$orderToSave->tax_group_id           = DB::table('product_type')->where('id', '= ', $bidToSave->product_type_id )->pluck('tax_group_id');
			$orderToSave->transport_brokerage_id = 0;
			$orderToSave->status_id              = 63;
			
			/* Retrieve corresponding brokerage rates */
			$productTypeBrokerageGroupID = DB::table('product_type')
                                      ->where('id', '=', $bidToSave->product_type_id)
                                      ->pluck('brokerage_group_id');
			$order_date = date("Y-m-d H:i:s");
      
			$brokerageInfo = Brokerage::lookupBrokerageOptions($orderToSave->locale_id,
                                                         $orderToSave->language_id,
                                                         $productTypeBrokerageGroupID,
                                                         $order_date);

			/* Calculate and save the brokerage rates */
			$brokeragCalc = Brokerage::calcBrokerage($brokerageInfo,
                                               $bidToSave->qty,
                                               $bidToSave->price);
      
			$orderToSave->brokerage = $brokeragCalc['brokerage_amount'];
			$orderToSave->brokerage_id = $brokeragCalc['brokerage_id'];
		
			$orderToSave->save();

			/* Make adjustments to the original Product (remaining quanities, etc) */	
			$productToSave->status_id = 54;
			$remainingQty = $productToSave->qty - $bidToSave->qty;
			$productToSave->qty = $remainingQty;
      /* If no product left, mark it as sold out */
			if($remainingQty == 0) {	
				$productToSave->status_id = 79;  
			}
			
			/* if minqty exceeds remaining product, then bring minqty down to match */
			if($productToSave->minqty > $productToSave->qty) {	
        $productToSave->minqty = $productToSave->qty;
			}
			$productToSave->save();

			/* Now that order is saved, get a full set of Order Details */
			$orderInfo = Order::getOrderInfo($orderToSave->id);

			/* By adding these vars to the arrays, their details will be accessble
         in the pdf.view and email.view */
			$viewData['pageData'] = $this->pageData;
			$viewData['orderInfo'] = $orderInfo;
			$viewData['viewInfo'] = array(
				'showBrokerageValues' => 0,
				'showPricing' => 1,
				'showMiscCharges' => 0,
				'titleLabel' => 'ORIGINAL',
			);

			/* Create PDFs of PO/BOL */	
			/* establish the path for the PDFS and render the view to pass as HTML
         content */
			$pdfBasePath = public_path('uplds/orderpdfs');

			/* PO PDF */
			$pdfViewPO = View::make('pdfs.view-bid-accept-purchase-order-pdf')
        ->with('viewData', $viewData);
			$pdfInstance = new \Thujohn\Pdf\Pdf();
			$pdfContent = $pdfInstance->load($pdfViewPO, 'letter', 'portrait')->output();
			$outputName = $orderInfo->accounting_number_display.'-PO-'.$viewData['viewInfo']['titleLabel'];
			$pdfPathPO = $pdfBasePath.'/'.$outputName.'.pdf';
			File::put($pdfPathPO, $pdfContent);

			/* BOL PDF */
			$pdfViewBOL = View::make('pdfs.view-bid-accept-bill-lading-pdf')
        ->with('viewData', $viewData);
			$pdfInstance=new \Thujohn\Pdf\Pdf();
      
			$pdfContent = $pdfInstance
          ->load($pdfViewBOL, 'letter', 'portrait')
          ->output();
          
			$outputName = $orderInfo->accounting_number_display.'-BOL-'.$viewData['viewInfo']['titleLabel'];
			$pdfPathBOL = $pdfBasePath.'/'.$outputName.'.pdf';
			File::put($pdfPathBOL, $pdfContent);

			/* Change some values before building the Warehouse PDFs */
			$viewData['viewInfo'] = array(
				'showBrokerageValues' => 0,
				'showPricing' => 0,
				'showMiscCharges' => 0,
				'titleLabel' => 'WAREHOUSE',
			);
			/* PO WAREHOUSE PDF */
			$pdfViewPO_Warehouse = View::make('pdfs.view-bid-accept-purchase-order-pdf')
        ->with('viewData', $viewData);
			$pdfInstance = new \Thujohn\Pdf\Pdf();
			$pdfContent = $pdfInstance
                    ->load($pdfViewPO_Warehouse, 'letter', 'portrait')
                    ->output();
                    
			$outputName = $orderInfo->accounting_number_display.'-PO-'.$viewData['viewInfo']['titleLabel'];
			$pdfPathPOWarehouse = $pdfBasePath.'/'.$outputName.'.pdf';
			File::put($pdfPathPOWarehouse, $pdfContent);
			
			/* BOL WAREHOUSE PDF */
			$pdfViewBOL_Warehouse = View::make('pdfs.view-bid-accept-bill-lading-pdf')
        ->with('viewData', $viewData);
			$pdfInstance = new \Thujohn\Pdf\Pdf();
			$pdfContent = $pdfInstance
                      ->load($pdfViewBOL_Warehouse, 'letter', 'portrait')
                      ->output();
			$outputName = $orderInfo->accounting_number_display.'-BOL-'.$viewData['viewInfo']['titleLabel'];
			$pdfPathBOLWarehouse = $pdfBasePath.'/'.$outputName.'.pdf';
			File::put($pdfPathBOLWarehouse, $pdfContent);

			/* Generate Order email notifications with PO/BOL attachments */
			/* if PRETEND is set, then display the email content instead */			
			if(Config::get('mail.pretend')) {	
				$pretendView = "";
				$pretendView .= $pdfViewPO;
				$pretendView .= $pdfViewBOL;
				$pretendView .= $pdfViewPO_Warehouse;
				$pretendView .= $pdfViewBOL_Warehouse;
			
				$pretendView .= '<BR><BR>EMAILS:<BR>';
				$pretendView .= View::make('emails.view-bid-accept-purchase-order-email')
					->with('viewData', $viewData);
				$pretendView .= View::make('emails.view-bid-accept-bill-lading-email')
					->with('viewData', $viewData);
				$pretendView .= View::make('emails.view-bid-accept-purchase-order-email-warehouse')
					->with('viewData', $viewData);
				$pretendView .= View::make('emails.view-bid-accept-bill-lading-email-warehouse')
					->with('viewData', $viewData);

				return $pretendView;
			}

			/* Send PO Email to Seller */ 
			/* email addresses - repeat additional 'toEmail' lines as needed */
			$toEmail[0] = array('email' => $this->pageData['companyEmail'], 'name' => $this->pageData['companyName']);
			$toEmail[1] = array('email' => $orderInfo->sellerInfo->email, 'name' => $orderInfo->sellerInfo->name);
 
			$fromEmail = array('email' => $this->pageData['companyEmail'], 'name' => $this->pageData['companyName']);
			$subject = $this->pageData['companyName'].' - Purchase Order '.$orderInfo->accounting_number_display;
			$attachments = array($pdfPathPO);

			/* the $pageData and $userInfo are passed as parameters to the mail tag so that */
			Mail::send('emails.view-bid-accept-purchase-order-email', 
        $viewData, 
        function($message) use ($toEmail,
                                $fromEmail,
                                $subject,
                                $attachments) {
          
				foreach($toEmail as $key => $value)
          $message->to($value['email'], $value['name']);
          
				$message->from($fromEmail['email'], $fromEmail['name']);
				$message->subject($subject);
        
				foreach($attachments as $key => $value) 
          $message->attach($value);
			});
			unset($toEmail);  // just to make sure
			unset($fromEmail);  // just to make sure
			
			/* Send PO Email to Seller Warehouse (shipping)*/ 
			/* email addresses - repeat additional 'toEmail' lines as needed */
			$toEmail[0] = array('email' => $orderInfo->sellerInfo->companyInfo->shipping_email, 
                        'name' => $orderInfo->sellerInfo->companyInfo->name.' Shipping');

			$fromEmail = array('email' => $this->pageData['companyEmail'], 
                         'name' => $this->pageData['companyName']);
			$subject = $this->pageData['companyName'].' - Purchase Order '.$orderInfo->accounting_number_display;
			$attachments = array($pdfPathPO);

			/* the $pageData and $userInfo are passed as parameters to the mail tag so that */
			Mail::send('emails.view-bid-accept-purchase-order-email-warehouse',
        $viewData,
        function($message) use ($toEmail, $fromEmail, $subject, $attachments) {
          
				foreach($toEmail as $key=>$value)
          $message->to($value['email'], $value['name']);
          
				$message->from($fromEmail['email'], $fromEmail['name']);
				$message->subject($subject);
        
				foreach($attachments as $key=>$value)
          $message->attach($value);
			});
			unset($toEmail);  // just to make sure
			unset($fromEmail);  // just to make sure

			/* Send BOL Email to Buyer */ 
			/* email addresses - repeat additional 'toEmail' lines as needed */
			$toEmail[0] = array('email' => $this->pageData['companyEmail'],
                          'name' => $this->pageData['companyName']);
			$toEmail[1] = array('email' => $orderInfo->buyerInfo->email,
                        'name' => $orderInfo->buyerInfo->name);

			$fromEmail = array('email' => $this->pageData['companyEmail'],
                        'name' => $this->pageData['companyName']);
      
			$subject = $this->pageData['companyName'].' - Bill of Lading '.$orderInfo->accounting_number_display;
			$attachments = array($pdfPathBOL);

			/* the $pageData and $userInfo are passed as parameters to the mail tag so that */
			Mail::send('emails.view-bid-accept-bill-lading-email', $viewData, function($message) use ($toEmail, $fromEmail, $subject, $attachments) {
				foreach($toEmail as $key => $value)
          $message->to($value['email'], $value['name']);
          
				$message->from($fromEmail['email'], $fromEmail['name']);
				$message->subject($subject);
        
				foreach($attachments as $key => $value)
          $message->attach($value);
			});
			unset($toEmail);  // just to make sure
			unset($fromEmail);  // just to make sure
			
			/* Send BOL Email to Buyer Warehouse (receiving) */ 
			/* email addresses - repeat additional 'toEmail' lines as needed */
			$toEmail[0] = array('email' => $orderInfo->buyerInfo->companyInfo->receiving_email, 
                        'name' => $orderInfo->buyerInfo->companyInfo->name.' Receiving');

			$fromEmail = array('email' => $this->pageData['companyEmail'],
                       'name' => $this->pageData['companyName']);
			$subject = $this->pageData['companyName'].' - Bill of Lading '.$orderInfo->accounting_number_display;
			$attachments = array($pdfPathBOL);

			/* the $pageData and $userInfo are passed as parameters to the mail tag so that */
			Mail::send('emails.view-bid-accept-bill-lading-email-warehouse',
        $viewData,
        function($message) use ($toEmail, $fromEmail, $subject, $attachments) {
          
				foreach($toEmail as $key => $value)
          $message->to($value['email'], $value['name']);
          
				$message->from($fromEmail['email'], $fromEmail['name']);
				$message->subject($subject);
        
				foreach($attachments as $key => $value)
          $message->attach($value);
          
			});
			unset($toEmail);  // just to make sure
			unset($fromEmail);  // just to make sure

			$emailStatusMessage = '';
			if(count(Mail::failures()) > 0 ) {
				echo "There was one or more failures. They were: <br>";
				foreach(Mail::failures() as $email_address)
					$emailStatusMessage .= "Failed recipient: $email_address <br>";
			} 
      else {
				$emailStatusMessage = "Your email has been successfully sent.";
			}

      echo "<A HREF='/create-edit-a-post'>/create-edit-a-post</A>";
			$messages = array('The Bid was successfully accepted.', $this->pageData['success']);
			return Redirect::to('/create-edit-a-post')
        ->with('messages', $messages);
		} // end of decision = Accept

		/* -----------------------------------------------*/
		/* if DECLINE */	
		/* -----------------------------------------------*/
		elseif($decision == 'decline') {
			/* Update bid status to declined, and capture accepter_id */	
			$bidToSave->accepter_id = Auth::id();
			$bidToSave->status_id = 62;
			$bidToSave->save();

			/* Start assembling the base info needed for the decline notification
         emails */
			$declineInfo['bidInfo'] = Bid::getBidInfo($bid_id);
			$declineInfo['bidderInfo'] = User::getUserInfo($declineInfo['bidInfo']->user_id);

			//$declineInfo['productInfo']=Product::getProductInfo($declineInfo['bidInfo']->product_id);


			///* Get details of the people involved with the product/bid */	
			//if($declineInfo['bidInfo']->bid_type=='sell')
			//{	/* When bidding to sell, the bidder (current user) is the seller, and the original poster is the buyer*/
				//$declineInfo['sellerInfo']=User::getUserInfo($declineInfo['bidInfo']->user_id);
				//$declineInfo['buyerInfo']=User::getUserInfo(Auth::id());
				//$declineInfo['originalPosterInfo']=User::getUserInfo($declineInfo['bidInfo']->product_owner_id);
			//}
			//else
			//{	/* When bidding to buy, the bidder (current user) is the buyer, and the original poster is the seller*/
				//$declineInfo['sellerInfo']=User::getUserInfo(Auth::id());
				//$declineInfo['buyerInfo']=User::getUserInfo($declineInfo['bidInfo']->user_id);
				//$declineInfo['originalPosterInfo']=User::getUserInfo($declineInfo['bidInfo']->product_owner_id);
			//}

			/* By adding these vars to the arrays, their details will be accessble
         in the pdf.view and email.view */
			$viewData['pageData'] = $this->pageData;
			$viewData['declineInfo'] = $declineInfo;


			/* Generate Order email notifications with PO/BOL attachments */
			/* if PRETEND is set, then display the email content instead */			
			if(Config::get('mail.pretend')) {	
				$pretendView = "";
				$pretendView .= '<BR><BR>EMAILS:<BR>';
				$pretendView .= View::make('emails.view-bid-decline-to-bidder-email')
					->with('viewData', $viewData);
				return $pretendView;
			}

			/* Send Decline email to Bidder */ 
			/* email addresses - repeat additional 'toEmail' lines as needed */
			$toEmail[0] = array('email' => $declineInfo['bidderInfo']->email,
                        'name' => $declineInfo['bidderInfo']->name);

			$fromEmail = array('email' => $this->pageData['companyEmail'],
                       'name' => $this->pageData['companyName']);
			$subject = $this->pageData['companyName'].' - Bid Decline - '.$declineInfo['bidInfo']->product_name.' '.$declineInfo['bidInfo']->variety_name;
			$attachments = array();

			/* the $pageData and $userInfo are passed as parameters to the mail tag so that */
			Mail::send('emails.view-bid-decline-to-bidder-email', 
        $viewData,
        function($message) use ($toEmail, $fromEmail, $subject, $attachments) {
          
				foreach($toEmail as $key => $value)
          $message->to($value['email'], $value['name']);
          
				$message->from($fromEmail['email'], $fromEmail['name']);
				$message->subject($subject);
				foreach($attachments as $key => $value)
          $message->attach($value);
			});
			unset($toEmail);  // just to make sure
			unset($fromEmail);  // just to make sure

			$emailStatusMessage = '';
			if(count(Mail::failures()) > 0 ) {
				echo "There was one or more failures. They were: <br>";
				foreach(Mail::failures() as $email_address) {
					$emailStatusMessage .= "Failed recipient: $email_address <br>";
				}
			}
      else {
				$emailStatusMessage = "Your email has been successfully sent.";
			}
			$messages = array('Your Bid was successfully declined.',
                      $this->pageData['success']);
			return Redirect::to('/create-edit-a-post')
					->with('messages', $messages);
		}  // end of decision==decline
		else {
			$msg = Lang::get('site_content.post_to_Product_Not_Exist');
			return Redirect::back()
				->withInput()
				->withErrors($msg);
		} 
	} // store()
} // class
?>
