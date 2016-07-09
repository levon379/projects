<?php
class AdminMainMenuController extends BaseController {
  
  /**-------------------------------------------------------------------------
   * main():
   *          main admin screen
   *                 
   *--------------------------------------------------------------------------
   *
   * @param  int  $id
   * @return Response
   *-------------------------------------------------------------------------*/
	public function main() {
		$messages = "Welcome to the Admin";
		return View::make('admin-main-menu')
			->with('pageData', $this->pageData)
			->with('messages', $messages);
	} // main()
} // class
?>
