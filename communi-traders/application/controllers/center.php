<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Center extends MX_Controller {

    public function index() {
        $name = $this->uri->segment(1, 1);
        $page_id = $this->uri->segment(2, 1);
        if ($name == 1) {
               $name = 'tool_index';
        }    
       
        $this->mysmarty->view('center_top');
        switch ($name) {
            case 'tool_index':
                $this->load->module($name)->index();
                break;
            case 'newpost':
                $this->load->module($name)->index();
                break;
            case 'myperformance':
                $this->load->module($name)->getStatictics();
            break;
            default:
                $this->load->module($name);
                $this->name = new $name;
                $pageData = $this->name->_this($page_id);
                if ($pageData) {
                    $this->mysmarty->assign($name, $pageData);
                }
                $this->mysmarty->view($name . '_main');
                break;
        }
    }

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */