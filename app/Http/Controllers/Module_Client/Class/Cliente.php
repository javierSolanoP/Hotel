<?php
namespace App\Http\Controllers\Module_Client\Class;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Require\AbstractClass\Usuario;
use App\Http\Controllers\Require\Trait\MethodsUser;
use App\Http\Controllers\Require\Trait\MethodsConnect;
use PharIo\Manifest\Email;

class Cliente extends Usuario {

    public function __construct(private $cedula = '', 
                                $nombre = '', $apellido = '', 
                                private $genero = '',
                                private $edad = '',
                                private $fecha_nacimiento = '',
                                $email = '', $password = '', $confirmPassword = '',
                                private $telefono = ''
                                )
    {

        parent::__construct($nombre,$apellido,$email,$password,$confirmPassword);

    }

    //Se importa los metodos de usuario: 
    use MethodsUser;

    public function __toString()
    {
        return $this->password;
    }

    //Realizar una valoracion de su experiencia de usuario en el 'Hotel':
    public function makeQualification()
    {}

    //Se importa los metodos de conexion: 
    use MethodsConnect;

}