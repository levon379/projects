<?php
class SellBoardDataController extends BaseController {

	public function main() {
		return View::make('hello');
	}
  
	public function showPageData() {
		return $this->pageData;
	}
} // class
?>
