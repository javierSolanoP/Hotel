<?php
namespace App\Http\Controllers\Module_Admin\Class;
use App\Http\Controllers\Require\AbstractClass\Usuario;
use App\Http\Controllers\Require\Trait\MethodsUser;
use App\Http\Controllers\Require\Trait\MethodsConnect;

class Recepcionista extends Usuario {

    public function __construct($nombre = '', 
                                $apellido = '', 
                                $email = '',
                                $password = '', 
                                $confirmPassword = '')
    {

        parent::__construct($nombre,$apellido,$email,$password,$confirmPassword);

    }

    //Se importa los metodos de usuario: 
    use MethodsUser;

    //Metodo para realizar el 'Check-In':
    public function makeCheck_In()
    {}

    //Metodo para realizar el 'Check-Out':
    public function makeCheck_Out()
    {}

    //Se importa los metodos de conexion: 
    use MethodsConnect;
    
}