<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['view'] = "home";
        $this->view_front($data);
    }

}
