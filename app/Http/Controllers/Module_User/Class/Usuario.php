<?php
namespace App\Http\Controllers\Module_User\Class;

use App\Http\Controllers\Require\Class\Validate;
use App\Http\Controllers\Require\Trait\MethodsUser;
use App\Http\Controllers\Require\Trait\MethodsConnect;

class Usuarios {

    public function __construct(private $cedula = '', 
                                private $nombre = '', 
                                private $apellido = '', 
                                private $genero = '',
                                private $edad = '',
                                private $fecha_nacimiento = '',
                                private $email = '', 
                                private $password = '', 
                                private $confirmPassword = '',
                                private $telefono = ''
                                ){}

    //Se importa los metodos de usuario: 
    use MethodsUser;

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