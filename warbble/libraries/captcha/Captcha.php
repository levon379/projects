<?php

require_once (ABSPATH . 'libraries/captcha/autoload.php');

use Gregwar\Captcha\CaptchaBuilder;

class Captcha
{
    public $instance    = false;
    private $builder    = false;
    public $phrase     = false;

    public function __construct()
    {
        $this->instance = Controller::get_instance();
        $this->phrase = $this->instance->session->userdata('captcha');
    }

    public function build($width = 150, $height = 45)
    {
        $this->builder = new CaptchaBuilder;
        $this->builder = $this->builder->build($width, $height);
        $this->phrase = $this->instance->session->set_userdata('captcha', $this->builder->getPhrase());
    }


    public function getbase64src()
    {
        $this->build();
        return $this->builder->inline();
    }

    public function check($value = '')
    {
       return $this->phrase === $value;
    }


}