<?php
namespace App\Http\Controllers\Module_Client\Class;
use App\Http\Controllers\Require\AbstractClass\Usuario;
use App\Http\Controllers\Require\Trait\MethodsUser;
use App\Http\Controllers\Require\Trait\MethodsConnect;

class Cliente extends Usuario {

    public function __construct($nombre, $apellido, $email, $password, $confirmPassword)
    {

        parent::$nombre          = $nombre;
        parent::$apellido        = $apellido;
        parent::$email           = $email;
        parent::$password        = $password;
        parent::$confirmPassword = $confirmPassword;

    }

    //Se importa los metodos de usuario: 
    use MethodsUser;

    //Realizar una valoracion de su experiencia de usuario en el 'Hotel':
    public function makeQualification()
    {}

    //Se importa los metodos de conexion: 
    use MethodsConnect;

}