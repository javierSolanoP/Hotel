<?php

namespace App\Http\Controllers\Module_User\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    //Metodo para devolver todos los roles que existen en la DB: 
    public function index()
    {
        //Hacemos la consulta en la DB:
        $model = Role::all();
        //Retornamos todos los registros encontrados en la DB:
        return ['roles' => $model];
    }

    //Metodo para registrar nuevos roles: 
    public function store(Request $request)
    {
        //En el caso de que el dato contenga caracteres de tipo mayuscula, los convertimos en minuscula. Asi seguimos una nomenclatura estandar: 
        $nombre_role = strtolower($request->input(key: 'nombre_role'));

        //Hacemos la consulta en la DB:
        $model = Role::where('nombre_role', $nombre_role);

        //Validamos si ese role existe en la DB: 
        $validate = $model->first();

        //Sino existe, hacemos el registro: 
        if(!$validate){

            try{

                //Registramos el nuevo 'role' en la DB: 
                Role::create(['nombre_role' => $nombre_role]);
                //Retornamos la respuesta: 
                return ['Register' => true];

            }catch(Exception $e){
                //Retornamos el error:
                return ['Register' => false, 'Error' => $e->getMessage()];
            }

        }else{
            //Retornamos el error: 
            return ['Register' => false, 'Error' => 'Ya existe en el sistema.'];
        }
    }

    //Metodo para devolver un role en especifico: 
    public function show($role)
    {
        //En el caso de que el dato contenga caracteres de tipo mayuscula, los convertimos en minuscula. Asi seguimos una nomenclatura estandar: 
        $nombre_role = strtolower($role);

        //Hacemos la consulta en la DB:
        $model = Role::where('nombre_role', $nombre_role)->first();

        //Validamos si ese role existe en la DB:
        if($model){
            //Retornamos el role solicitado:
            return ['role' => $model];
        }else{
            //Retornamos el error:
            return ['Error' => 'No existe en el sistema.'];
        }

    }

    //Metodo para actualizar un role: 
    public function update(Request $request)
    {
        //En el caso de que el dato contenga caracteres de tipo mayuscula, los convertimos en minuscula. Asi seguimos una nomenclatura estandar: 
        $nombre_role     = strtolower($request->input(key: 'nombre_role'));
        $new_nombre_role = strtolower($request->input(key: 'new_nombre_role'));

        //Hacemos la consulta en la DB: 
        $model = Role::where('nombre_role', $nombre_role);

        //Validamos que ese role exista en la DB:
        $validate = $model->first();

        //Si existe ese role, hacemos la actualizacion: 
        if($validate){

            try{

                //Hacemos la actualizacion en la DB:
                $model->update(['nombre_role' => $new_nombre_role]);
                //Retornamos la respuesta:
                return ['Register' => true];

            }catch(Exception $e){
                //Retornamos el error:
                return ['Register' => false, 'Error' => $e->getMessage()];
            }
        }else{
            //Retornamos el error:
            return ['Register' => false, 'Error' => 'No existe en el sistema.'];
        }
    }

    //Metodo para eliminar un role:
    public function destroy($role)
    {
        //En el caso de que el dato contenga caracteres de tipo mayuscula, los convertimos en minuscula. Asi seguimos una nomenclatura estandar: 
        $nombre_role = strtolower($role);

        //Hacemos la consulta en la DB:
        $model = Role::where('nombre_role', $nombre_role);

        //Validamos que ese role exista en la DB:
        $validate = $model->first();

        //Si existe ese role, hacemos la eliminacion: 
        if($model){

            try{

                //Hacemos la eliminacion del role en la DB:
                $model->delete();
                //Retornamos la respuesta:
                return ['Delete' => true];

            }catch(Exception $e){
                //Retornamos el error:
                return ['Delete' => false, 'Error' => $e->getMessage()];
            }
        }else{
            //Retornamos el error:
            return ['Delete' => 'No existe en el sistema.'];
        }
    }
}
