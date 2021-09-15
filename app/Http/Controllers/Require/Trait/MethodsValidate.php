<?php
namespace App\Http\Controllers\Require\Trait;

trait MethodsValidate {

    public function validateString($data)
    {
        if(isset($data)){

            if(!preg_match("/[0-9]/", $data)){
            
                return  true;

            }else{

                return false;

            }
        }
    }

    public function validateNumber($data)
    {
        if(isset($data)){

            if(!preg_match("/[a-zA-Z]/", $data)){
            
                return  true;

            }else{

                return false;

            }
        }
    }

    public function validateEmail($data)
    {
        if(isset($data)){
                
            //Validamos el campo email: 
            $pos = filter_var($data, FILTER_VALIDATE_EMAIL);
            if($pos){

                return  true;

            }else{

                return  false;

            }
        }
    }

    public function validatePassword($password, $hash)
    {
        if(isset($password) && isset($hash)){

            $verify = password_verify($password, $hash);

            if($verify){

                return true;

            }else{

                return false;

            }
        }
    }
}