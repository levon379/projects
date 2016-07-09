<?php
class BaseController extends Controller {

    protected $layout = "layout.default";
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
        protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    public function get_filenames($path) {
        $files          = scandir($path);
        $Images = array();
        foreach ($files as $key => $file) {
            if (File::isFile($path . '/' . $file)) {
                array_push($Images, $files[$key]);
            }
        }
        return $Images;
    }

}
