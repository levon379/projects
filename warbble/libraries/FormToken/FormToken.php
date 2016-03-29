<?php


class FormToken
{
    public $instance    = false;
    public $token       = false;

    public function __construct()
    {
        $this->instance = Controller::get_instance();
    }

    public function getToken()
    {
        return $this->instance->session->userdata('formToken');
    }

    public function is_token_valid()
    {
        $result = false;
        if ($this->getToken() == $_POST['formToken']) {
            $result = true;
        }
        $new_token = $this->renderToken();
        return $result ? $new_token: false;
    }

    public function renderToken()
    {
        $this->token = md5(uniqid(rand(), true));
        $this->instance->session->set_userdata('formToken', $this->token);
        return $this->token;
    }



}