<?php
namespace App\Http\Controllers\Module_Admin\Class;
use App\Http\Controllers\Require\AbstractClass\Usuario;
use App\Http\Controllers\Require\Trait\MethodsUser;
use App\Http\Controllers\Require\Trait\MethodsConnect;

class Administrador extends Usuario {

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

    //Metodo para registrar los datos basicos del Hotel en el sistema:
    public function registerHotelData()
    {}

    //Metodo para registrar sucursales en el sistema: 
    public function registerBranchData()
    {}

    //Se importa los metodos de conexion: 
    use MethodsConnect;

}