<?php
namespace App\Http\Controllers\Module_Admin\Class;
use App\Http\Controllers\Require\AbstractClass\Usuario;
use App\Http\Controllers\Require\Trait\MethodsUser;
use App\Http\Controllers\Require\Trait\MethodsAdmin;
use App\Http\Controllers\Require\Trait\MethodsConnect;

class Administrador extends Usuario {

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

    //Se importa los metodos administrativos comunes: 
    use MethodsAdmin;

    //Metodo para registrar los datos basicos del Hotel en el sistema:
    public function registerHotelData()
    {}

    //Metodo para registrar sucursales en el sistema: 
    public function registerBranchData()
    {}

    //Se importa los metodos de conexion: 
    use MethodsConnect;

}