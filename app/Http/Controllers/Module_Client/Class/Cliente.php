<?php
namespace App\Http\Controllers\Module_Client\Class;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Require\AbstractClass\Usuario;
use App\Http\Controllers\Require\Class\Validate;
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

    public function __getEmail()
    {
        return $this->email;
    }

    //Realizar una valoracion de su experiencia de usuario en el 'Hotel':
    public function makeQualification($qualification)
    {

        $validate = new Validate;

        //Validamos que la calificacion ingresada, sea un tipo de dato numerico: 
        if($validate->validateNumber($qualification)){
            //Retornamos la respuesta:
            return ['qualification' => true];
        }else{
            //Retornamos el error: 
            return ['qualification' => false, 'Error' => 'No es un tipo de dato numerico.'];
        }
    }

    //Se importa los metodos de conexion: 
    use MethodsConnect;

}