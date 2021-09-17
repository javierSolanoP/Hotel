<?php

namespace App\Http\Controllers\Module_User\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Module_User\Class\Permiso;
use App\Models\Permisos;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class PermisosController extends Controller
{
    //Metodo para devolver todos los permisos que existen en la DB: 
    public function index()
    {
        //Hacemos la consulta a la DB: 
        $model = Permisos::all();
        //Retornamos la respuesta: 
        return ['Permission' => $model];
    }

    //Metodo para registrar nuevos permisos: 
    public function store(Request $request)
    {
        //Instanciamos la clase el controlador 'Role', para validar si existe el role: 
        $role = new RoleController;
        //Validamos si existe el role en la DB: 
        $validateRole = $role->show($request->input(key: 'nombre_role'));

        //Si existe, extraemos su 'id': 
        if($validateRole['Query']){

            //Id del role: 
            $id_role = $validateRole['role']['id_role'];

            try{

                //Hacemos la consulta a la DB: 
                $queryPermissions = Permisos::where('id_role', $id_role);

                //Validamos que no exista un permiso para ese role: 
                $validatePermissions = $queryPermissions->first();

                //Sino existe, lo registramos: 
                if(!$validatePermissions){

                    //En el caso de que el dato contenga caracteres de tipo mayuscula, los convertimos en minuscula. Asi seguimos una nomenclatura estandar: 
                    $nombre_permiso = strtolower($request->input(key: 'nombre_permiso'));

                    //Instanciamos la clase 'Permiso', para validar los datos recibidos: 
                    $permission = new Permiso;
                    $validateRoleName = $permission->validatePermissionName(permissionName:  $nombre_permiso);

                    //Si es un tipo de dato permitido, lo ingresamos en el sistema: 
                    if($validateRoleName){

                        try{
    
                            //Hacemos el registro del nuevo permiso: 
                            Permisos::create(['id_role' => $id_role, 'nombre_permiso' => $nombre_permiso]);
                            //Retornamos la respuesta: 
                            return ['Register' => true];
    
                        }catch(Exception $e){
                            //Retornamos el error: 
                            return ['Register' => false, 'Error' => $e->getMessage()];
                        }
                    }else{
                        //Retornamos el error: 
                        return ['Register' => false, 'Error' => 'Tipo de dato no permitido.'];
                    }
                }else{
                    //Retornamos el error: 
                    return ['Register' => false, 'Error' => 'Ya existe ese permiso en el sistema.'];
                }
            }catch(Exception $e){
                //Retornamos el error: 
                return ['Register' => false, 'Error' => $e->getMessage()];
            }
        }else{
            //Retornamos el error: 
            return ['Register' => false, 'Error' => 'No existe ese role'];
        }
    }
    

    //Metodo para devolver un permiso en especifico: 
    public function show($role)
    {
        //En el caso de que el dato contenga caracteres de tipo mayuscula, los convertimos en minuscula. Asi seguimos una nomenclatura estandar: 
        $nombre_role = strtolower($role);

        //Instanciamos el controlador de la clase 'Role', para validar si existe un permiso para ese role: 
        $roleController = new RoleController;
        //Validamos si existe el role: 
        $validateRole = $roleController->show(role: $nombre_role);

        //Si esxiste, extraemos su 'id': 
        if($validateRole['Query']){

            //Extraemos su 'id': 
            $id_role = $validateRole['role']['id_role'];

            //Hacemos la consulta en la DB: 
            $modelPermissions = Permisos::where('id_role', $id_role)->first();

            //Validamos que exista el permiso: 
            if($modelPermissions){
                //Retornamos la respuesta: 
                return ['Query' => true, 'Permission' => $modelPermissions];
            }else{
                //Retornamos el error: 
                return ['Query' => false, 'Error' => 'No existe ese permiso en el sistema.'];
            }
        }else{
            //Retornamos el error: 
            return ['Query' => false, 'Error' => 'No existe ese role en el sistema.'];
        }
    }

    //Metodo para actualizar un permiso:
    public function update(Request $request)
    {
       //Instanciamos la clase del controlador 'Role', para validar si existe el role: 
       $role = new RoleController;
       //Validamos si existe el role en la DB: 
       $validateRole = $role->show($request->input(key: 'nombre_role'));

       //Si existe, extraemos su 'id': 
       if($validateRole['Query']){

           //Id del role: 
           $id_role = $validateRole['role']['id_role'];

           try{

               //Hacemos la consulta a la DB: 
               $modelPermissions = Permisos::where('id_role', $id_role);

               //Validamos que exista un permiso para ese role: 
               $validatePermissions = $modelPermissions->first();

               //Si existe, lo actualizamos: 
               if($validatePermissions){

                   try{

                       //En el caso de que el dato contenga caracteres de tipo mayuscula, los convertimos en minuscula. Asi seguimos una nomenclatura estandar: 
                       $new_nombre_permiso = strtolower($request->input(key: 'new_nombre_permiso'));

                       //Instanciamos la clase 'Permiso', para validar los datos recibidos: 
                       $permission = new Permiso;
                       $validateRoleName = $permission->validatePermissionName(permissionName:  $new_nombre_permiso);

                       //Si es un tipo de dato permitido, lo ingresamos en el sistema: 
                       if($validateRoleName){

                            try{

                                //Hacemos la actualizacion del permiso: 
                                $modelPermissions->update(['nombre_permiso' => $new_nombre_permiso]);
                                //Retornamos la respuesta: 
                                return ['Register' => true];
                            }catch(Exception $e){
                                //Retornamos el error: 
                                return ['Register' => false, 'Error' => $e->getMessage()];
                            }
                       }else{
                           //Retornamos el error: 
                           return ['Register' => false, 'Error' => 'Tipo de dato no permitido.'];
                       }

                   }catch(Exception $e){
                       //Retornamos el error: 
                       return ['Register' => false, 'Error' => $e->getMessage()];
                   }
               }else{
                   //Retornamos el error: 
                   return ['Register' => false, 'Error' => 'No existe ese permiso en el sistema.'];
               }
           }catch(Exception $e){
               //Retornamos el error: 
               return ['Register' => false, 'Error' => $e->getMessage()];
           }
       }else{
           //Retornamos el error: 
           return ['Register' => false, 'Error' => 'No existe ese role'];
       }
   
    }

    //Metodo para eliminar un permiso: 
    public function destroy($role)
    {
        //En el caso de que el dato contenga caracteres de tipo mayuscula, los convertimos en minuscula. Asi seguimos una nomenclatura estandar: 
        $nombre_role = strtolower($role);   

        //Instanciamos el controlador de la clase 'Role', para validar si existe un permiso para ese role: 
        $roleController = new RoleController;
        //Validamos si existe el role: 
        $validateRole = $roleController->show(role: $nombre_role);

        //Si existe, extraemos su 'id': 
        if($validateRole['Query']){

            try{

                //Extraemos su 'id': 
                $id_role = $validateRole['role']['id_role'];

                //Realizamos la consulta a la DB: 
                $modelPermissions = Permisos::where('id_role', $id_role);

                //Validamos que exista el permiso: 
                $validatePermissions = $modelPermissions->first();

                //Si existe, realizamos la eliminacion: 
                if($validatePermissions){

                    //Realizamos la eliminacion: 
                    $modelPermissions->delete();
                    //Retornamos la respuesta: 
                    return ['Delete' => true];
                }else{
                    //Retornamos el error: 
                    return ['Delete' => false, 'Error' => 'No existe ese permiso en el sistema.'];
                }
            }catch(Exception $e){
                //Retornamos el error: 
                return ['Delete' => false, 'Error' => $e->getMessage()];
            }

        }else{
            //Retornamos el error: 
            return ['Delete' => false, 'Error' => 'No existe ese role en el sistema.'];
        }

    }   
}
