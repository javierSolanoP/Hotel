<?php

namespace App\Http\Controllers\Module_User\Class;

use App\Http\Controllers\Require\Trait\MethodsValidate;

class Role {

    //El constructor de la clase, para poder crear instancias: 
    public function __construct(){}

    //Usamos los metodos proporcionados por el trait, para validar los datos recibidos: 
    use MethodsValidate;
}