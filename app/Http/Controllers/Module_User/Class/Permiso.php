<?php

namespace App\Http\Controllers\Module_User\Class;

use App\Http\Controllers\Require\Class\Validate;

class Permiso {

    //El constructor de la clase, para poder crear instancias: 
    public function __construct(){}

    public function validateIdRole($id_role)
    {
        //Instanciamos la clase 'Validate', para poder validar los datos recibidos: 
        $validate = new Validate;

        //Validamos que el dato sea de tipo numerico: 
        if($validate->validateNumber(data: $id_role)){
            //Retornamos una respuesta satisfactoria:  
            return true;
        }else{
            //Retornamos una respuesta NO satisfactoria: 
            return false;
        }
    }

    public function validatePermissionName($permissionName)
    {
        //Instanciamos la clase 'Validate', para poder validar los datos recibidos: 
        $validate = new Validate;

        //Validamos que el dato sea de tipo string: 
        if($validate->validateString(data: $permissionName)){
            //Retornamos una respuesta satisfactoria:  
            return true;
        }else{
            //Retornamos una respuesta NO satisfactoria: 
            return false;
        }
    }
}