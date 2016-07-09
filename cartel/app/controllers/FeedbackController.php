<?php
class FeedbackController extends BaseController {

  /**-------------------------------------------------------------------------
  * processReferral():
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
  function processReferral() {
    $referral = Input::get('referral', 'friend');
    return Redirect::back()->with('messages', 'You were referred by '.
                                    $referral);
  } // processReferral()
} // class
?>
