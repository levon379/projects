<?php
class TermsOfUseController extends BaseController {
  
  /**-------------------------------------------------------------------------
  * termsOfUse(): shows the terms of use page      
  *
  * @return Response
  *-------------------------------------------------------------------------*/
	public function termsOfUse() {
    $termsContent = DB::table('content')
      ->where('locale_id', '=', $this->pageData['locale_id'])
      ->where('language_id', '=', $this->pageData['language_id'])
      ->where('name', '=', 'terms_of_use_Content')
      ->pluck('content');
    return View::make('terms-of-use')
      ->with('termsContent', $termsContent);
	} // termsOfUse()

  /**-------------------------------------------------------------------------
  * submitTermsOfUse(): Accepts post from the terms of use page.  
  *
  * @return Response
  *-------------------------------------------------------------------------*/
	public function submitTermsOfUse() {
		/* Get inbound form values */
		$accept = Input::get('accept');
		Session::put('terms', $accept);
		if($accept) {
			return Redirect::intended('/create-edit-a-post');
		} 
    else {
			$termsContent = DB::table('content')
        ->where('locale_id', '=', $this->pageData['locale_id'])
        ->where('language_id', '=', $this->pageData['language_id'])
        ->where('name', '=', 'terms_of_use_Content')
        ->pluck('content');
			return View::make('terms-of-use')
				->with('termsContent', $termsContent);
		}
	} // submitTermsOfUse()
} // class
?>
