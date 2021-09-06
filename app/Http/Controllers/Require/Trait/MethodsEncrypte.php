<?php
namespace App\Http\Controllers\Require\Trait;

trait MethodsEncrypte {

    public function encryptePassword($password)
    {

        $encrypte = password_hash($password, PASSWORD_BCRYPT, ['cost' => 5]);
        $verify   = password_verify($password, $encrypte);

        if($verify){

            return $encrypte;

        }else{

            return ['encrypte' => false, 'Error' => 'Error de hash. '];
        }

    }
}