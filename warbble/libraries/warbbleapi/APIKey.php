<?php


class APIKey
{
    private $key = false;
    private $instance = false;

    function __construct($key)
    {
        $this->key = $key;
        $this->instance = Controller::get_instance();
    }

    public function verifyKey()
    {
        //$user =
    }
}