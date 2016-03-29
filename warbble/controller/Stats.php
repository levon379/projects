<?php

class Stats extends Controller
{
    public function index()
    {
        $this->_css = array(
            array(
                'type' => 'admin',
                'file' => 'stats/normalize.css',
            ),
            array(
                'type' => 'admin',
                'file' => 'stats/style.css',
            )
        );
        $dis = array();
        $dis['users'] = Users_Model::all();
        $this->layout('admin', 'stats/index', $dis);
    }
}