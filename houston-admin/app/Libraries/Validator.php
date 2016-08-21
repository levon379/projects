<?php namespace App\Libraries;


class Validator extends \Illuminate\Validation\Validator
{


    public function validateImageRequired($attribute, $value, $parameters = null){
        if(isset($value)) {
            if(count($value) < 2 && $value[0] == NULL)
                return false;
        }
        return true;
    }

    public function validateStrongPassword($attribute, $value, $parameters = null){
        if(isset($value)) {
            if(preg_match('/[^a-zA-Z0-9]/', $value) && preg_match('/[0-9]/', $value) && preg_match('/[0-9]/', $value) && preg_match('/[a-zA-Z]/', $value)){
                return true;
            }
        }
        return false;
    }

    public function validateDateEur($attribute, $value, $parameters = null){
        if(isset($value)){
            if(preg_match('/(\d{2})\/(\d{2})\/(\d{4})/',$value)){
                return true;
            }
        }
        return false;
    }


    public function validateAtLeast($attribute, $value, $parameters = null){
        if(isset($value)){
            if($value >= $parameters[0])
                return true;
        }
        return false;
    }


    public function validateRequiredZero($attribute, $value, $parameters = null){
        if(isset($value)){
            if((int)$value > 0)
                return true;
        }
        return false;
    }

}