<?php
class IndexController extends BaseController {

  /**-------------------------------------------------------------------------
  * index(): shows the index page
  *                 
  * @param  int  $id
  * @return Response
  *-------------------------------------------------------------------------*/
	public function index() {
		return View::make('index')
      ->with('pageData', $this->pageData);
	} // index()
} // class
?>
