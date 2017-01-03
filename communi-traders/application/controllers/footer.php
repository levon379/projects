<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Footer extends MX_Controller {

    public function index() {
              $this->mysmarty->view('footer_main');
            return true;
    }

}

/* End of file footer.php */
/* Location: ./application/controllers/footer.php */