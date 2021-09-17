<?php

namespace App\Http\controllers\Module_User\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Module_User\Class\Usuario;
use App\Models\Usuarios as ModelsUsuarios;
use Exception;

class UsuariosController extends Controller
{
    //Metodo para devolver todos los usuarios de la DB:
    public function index()
    {
        //Realizamos la consulta a la DB: 
        $modelUsers = ModelsUsuarios::all();

        //Eliminamos el 'hash' del campo password, por seguridad: 
        foreach($modelUsers as $user){
            unset($user['password']);
        }
        //Retoranamos la respuesta: 
        return ['Users' => $modelUsers];
    }

    //Metodo para registrar un nuevo Usuario:
    public function store($email,
                          $cedula,
                          $nombre,
                          $apellido,
                          $genero,
                          $edad,
                          $fecha_nacimiento,
                          $password,
                          $confirmPassword,
                          $telefono,
                          $role)
    {
        $model = ModelsUsuarios::where('email', $email);

        //Validamos que el usuario no exista en la DB: 
        $validate = $model->first();

        if (!$validate) {

            //Instanciamos la clase 'Cliente' para procesar los datos: 
            $client = new Usuario(
                cedula: $cedula,
                nombre: $nombre,
                apellido: $apellido,
                genero: $genero,
                edad: $edad,
                fecha_nacimiento: $fecha_nacimiento,
                email: $email,
                password: $password,
                confirmPassword: $confirmPassword,
                telefono: $telefono
            );

            //Almacenamos la instancia en una sesion para enviar los datos al trait 'MethodsUser': 
            $_SESSION['registerData'] = $client;

            $response = $client->registerData();

            if ($response) {

                try {

                    //En el caso de que el role contenga caracteres de tipo mayuscula, los convertimos en minuscula. Asi seguimos una nomenclatura estandar: 
                    $nombre_role = strtolower($role);

                    //Instanciamos la clase del controlador 'Role', para validar si existe el role: 
                    $role = new RoleController;
                    //Validamos si existe el role en la DB: 
                    $validateRole = $role->show(role: $nombre_role);

                    //Si existe, extraemos su 'id': 
                    if ($validateRole['Query']) {
                        //Extraemos su 'id' y se lo asignamos a la variable: 
                        $id_role = $validateRole['role']['id_role'];
                    } else {
                        //Retornamos el error: 
                        return ['Register' => false, 'Error' => 'No existe ese role en el sistema.'];
                    }

                    //Asignamos el 'hash' generado de la password en la variable: 
                    $hashPassword = $response['fields']['password'];

                    //Asignamos un estado de sesion por defecto como 'Inactiva': 
                    static $session = 'Inactiva';

                    //Insrtamos el nuevo registro en la DB: 
                    ModelsUsuarios::create(['cedula'           => $cedula,
                                            'nombre'           => $nombre,
                                            'apellido'         => $apellido,
                                            'genero'           => $genero,
                                            'edad'             => $edad,
                                            'fecha_nacimiento' => $fecha_nacimiento,
                                            'email'            => $email,
                                            'password'         => $hashPassword,
                                            'telefono'         => $telefono,
                                            'sesion'           => $session,
                                            'id_role'          => $id_role]);

                    //Eliminamos el 'hash' de la password, por temas de seguridad:
                    unset($response['fields']['password']);
                    //Retornamos la respuesta: 
                    return $response;

                } catch (Exception $e) {
                    //Retornamos el error: 
                    return ['register' => false, 'Error' => $e->getMessage()];
                }
            } else {
                //Retornamos el error en el caso de un tipo de dato no permitido: 
                return $response;
            }
        } else {
            //Retornamos el error: 
            return ['register' => false, 'Error' => 'Este cliente ya existe en el sistema.'];
        }
    }

    //Metodo para retornar la informacion del cliente solicitado: 
    public function show($email)
    {
        //Realizamos la consulta en la DB: 
        $model = ModelsUsuarios::where('email', $email)->first();

        //Validamos que exista el usuario: 
        if ($model) {

            try {
                //Eliminamos el 'hash' de la password, por temas de seguridad:  
                unset($model['password']);
                //Retornamos la informacion del cliente: 
                return $model;
            } catch (Exception $e) {
                return ['Error' => $e->getMessage()];
            }
        } else {
            //Retornamos el error: 
            return ['Error' => 'No existe en el sistema'];
        }
    }

    //Metodo para actualizar los datos del Cliente: 
    public function update($email, $newPassword, $confirmPassword, $telefono, $role)
    {
        $model = ModelsUsuarios::where('email', $email);

        //Validamos que el usuario no exista en la DB: 
        $validate = $model->first();

        if ($validate) {

            //Instanciamos la clase 'Cliente' para procesar los datos: 
            $client = new Usuario(
                password: $newPassword,
                confirmPassword: $confirmPassword,
                telefono: $telefono
            );

            //Almacenamos la instancia en una sesion para enviar los datos al trait 'MethodsUser': 
            $_SESSION['registerData'] = $client;

            $response = $client->registerData();

            if ($response) {

                try {

                    //En el caso de que el role contenga caracteres de tipo mayuscula, los convertimos en minuscula. Asi seguimos una nomenclatura estandar: 
                    $nombre_role = strtolower($role);

                    //Instanciamos la clase del controlador 'Role', para validar si existe el role: 
                    $role = new RoleController;
                    //Validamos si existe el role en la DB: 
                    $validateRole = $role->show(role: $nombre_role);

                    //Si existe, realizamos la actualizacion: 
                    if ($validateRole['Query']) {

                        //Asignamos el nuevo 'hash', a la variable 'password': 
                        $password = $response['fields']['password'];

                        //Realizamos la actualizacion en la DB: 
                        $model->update([
                            'password' => $password,
                            'telefono' => $telefono
                        ]);

                        //Eliminamos el 'hash' de la password, por temas de seguirad:
                        unset($response['fields']['password']);
                        //Retornamos la respuesta: 
                        return $response;
                    } else {
                        //Retornamos el error: 
                        return ['Register' => false, 'Error' => 'No existe ese role en el sistema.'];
                    }
                } catch (Exception $e) {
                    return ['register' => false, 'Error' => $e->getMessage()];
                }
            } else {

                return $response;
            }
        } else {

            return ['register' => false, 'Error' => 'No existe ese usuario en el sistema.'];
        }
    }

    //Metodo para eliminar un usuario en especifico: 
    public function destroy($email)
    {
        $model = ModelsUsuarios::where('email', '=', $email);

        //Validamos que el usuario exista en el DB: 
        $validate = $model->first();

        if ($validate) {

            try {
                //Eliminamos el usuario de la DB:  
                $model->delete();
                //Retornamos la informacion del usuario: 
                return ['Delete' => true];
            } catch (Exception $e) {
                return ['Delete' => false, 'Error' => $e->getMessage()];
            }
        } else {
            //Retornamos el error: 
            return ['Delete' => false, 'Error' => 'No existe en el sistema'];
        }
    }
}
