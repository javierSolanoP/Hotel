<?php

namespace App\Http\Controllers\Module_Client\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Module_Client\Class\Cliente;
use App\Models\Clientes;
use Exception;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    //Tratamiento de las acciones basicas del Usuario:
    public function store(Request $request)
    {
        //Formulario de la peticion: 
        $form = $request->input(key: 'form');

        //Tipos de formularios: 

        //Formulario de registro de cliente:     
        static $register        = 'register';

        //Formulario de inicio de sesion de cliente: 
        static $login           = 'login';

        //Formulario de restablecimiento de contrasenia, cliente: 
        static $restorePassword = 'restorePassword';

        //Formulario de cerrar sesion de cliente: 
        static $closeLogin      = 'closeLogin';

        //Formulario para registrar una calificacion de experiencia de cliente: 
        static $qualification   = 'qualification';

        //Distribuimos las instrucciones para cada formulario: 
        switch ($form) {

            case $register:

                $model = Clientes::where('email', '=', $request->input(key: 'email'));

                //Validamos que el usuario no exista en la DB: 
                $validate = $model->first();

                if (!$validate) {

                    //Instanciamos la clase 'Cliente' para procesar los datos: 
                    $client = new Cliente(
                        cedula: $request->input(key: 'cedula'),
                        nombre: $request->input(key: 'nombre'),
                        apellido: $request->input(key: 'apellido'),
                        genero: $request->input(key: 'genero'),
                        edad: $request->input(key: 'edad'),
                        fecha_nacimiento: $request->input(key: 'fecha_nacimiento'),
                        email: $request->input(key: 'email'),
                        password: $request->input(key: 'password'),
                        confirmPassword: $request->input(key: 'confirmPassword'),
                        telefono: $request->input(key: 'telefono')
                    );

                    //Almacenamos la instancia en una sesion para enviar los datos al trait 'MethodsUser': 
                    $_SESSION['registerData'] = $client;

                    $response = $client->registerData();

                    if ($response) {

                        try {

                            $insert = $request->except(['form', 'password', 'confirmPassword']);
                            $insert['password'] = $response['fields']['password'];
                            $insert['sesion']   = 'Inactiva';
                            Clientes::create($insert);
                            //Eliminamos el 'hash' de la password, por temas de seguirad:
                            unset($response['fields']['password']);
                            //Retornamos la respuesta: 
                            return $response;
                        } catch (Exception $e) {
                            return ['register' => false, 'Error' => $e->getMessage()];
                        }
                    } else {

                        return $response;
                    }
                } else {

                    return ['register' => false, 'Error' => 'Este cliente ya existe en el sistema.'];
                }

                break;

            case $login:

                $model = Clientes::where('email', '=', $request->input(key: 'email'));

                //Validamos que el usuario exista en la DB: 
                $validate = $model->first();

                if ($validate) {

                    //Validamos que el usuario no tenga una sesion activa en el sistema: 
                    if ($validate['sesion'] == 'Inactiva') {

                        //Extraemos el 'hash' del cliente, para hacer la validacion: 
                        $confirmPassword = $validate['password'];

                        //Instanciamos la clase 'Cliente' para procesar los datos:
                        $client = new Cliente(
                            password: $request->input(key: 'password'),
                            confirmPassword: $confirmPassword
                        );

                        $_SESSION['login'] = $client;

                        $response = $client->login();

                        if ($response) {

                            try {

                                $login = $model->update(['sesion' => 'Activa']);
                                return $response;
                            } catch (Exception $e) {

                                return ['login' => false, 'Error' => $e->getMessage()];
                            }
                        } elseif (!$response) {
                            return $response;
                        }
                    } else {

                        return ['login' => false, 'Error' => 'Tiene la sesion activa.'];
                    }
                } else {

                    return ['login' => false, 'Error' => 'No existe en el sistema.'];
                }

                break;

            case $restorePassword:

                $model = Clientes::where('email', '=', $request->input(key: 'email'));

                //Validamos que el usuario exista en la DB: 
                $validate = $model->first();

                //Estado de sesiones: 
                static $inactive = 'Inactiva';
                static $pending  = 'Pendiente';

                if ($validate) {

                    $client = new Cliente(
                        password: $request->input(key: 'newPassword'),
                        confirmPassword: $request->input(key: 'confirmPassword')
                    );

                    $response = $client->restorePassword(
                        url: $request->input(key: 'url'),
                        user: $validate['email'],
                        updated_at: $validate['updated_at'],
                        sessionStatus: $validate['sesion'],
                        newPassword: $request->input(key: 'newPassword')
                    );

                    if ($validate['sesion'] == $inactive) {

                        if ($response) {

                            try {

                                //Cambiamos el estado de la sesion: 
                                $model->update(['sesion' => 'Pendiente']);
                                //Retornamos la respuesta: 
                                return $response;
                            } catch (Exception $e) {
                                //Retornamos el error: 
                                return ['restorePassword' => false, 'Error' => $e->getMessage()];
                            }
                        } else {
                            //Retornamos el error:
                            return $response;
                        }
                    } elseif ($validate['sesion'] == $pending) {

                        if ($response['restorePassword']) {

                            try {

                                //Actualizamos el estado de la sesion y la nueva contrasenia del usuario: 
                                $model->update(['sesion' => $inactive, 'password' => $response['newPassword']]);
                                //Retornamos la respuesta: 
                                return $response;
                            } catch (Exception $e) {
                                //Retornamos el error: 
                                return ['restorePassword' => false, 'Error' => $e->getMessage()];
                            }
                        } else {

                            try {

                                //Actualizamos el estado de la sesion: 
                                $model->update(['sesion' => $inactive]);
                                //Retornamos el error: 
                                return $response;
                            } catch (Exception $e) {
                                //Retornamos el error: 
                                return ['restorePassword' => false, 'Error' => $e->getMessage()];
                            }
                        }
                    } else {
                        //Retornamos el error:
                        return $response;
                    }
                } else {
                    //Retornamos el error: 
                    return ['restorePassword' => false, 'Error' => 'No existe en el sistema.'];
                }

                break;

            case $closeLogin:

                $model = Clientes::where('email', '=', $request->input(key: 'email'));

                //Validamos que el usuario exista en la DB: 
                $validate = $model->first();

                if ($validate) {

                    //Estado de sesion: 
                    static $active = 'Activa';

                    if ($validate['sesion'] == $active) {

                        try {

                            //Actualizamos la sesion a 'Inactiva': 
                            $model->update(['sesion' => 'Inactiva']);
                            //Retornamos la respuesta: 
                            return ['closeLogin' => true];
                        } catch (Exception $e) {
                            //Retornamos el error: 
                            return ['closeLogin' => false, 'Error' => $e->getMessage()];
                        }
                    } else {
                        //Retornamos el error: 
                        return ['closeLogin' => false, 'Error' => 'El cliente no ha iniciado sesion en el sistema.'];
                    }
                } else {
                    //Retornamos el error: 
                    return ['closeLogin' => false, 'Error' => 'No existe en el sistema.'];
                }

                break;

            case $qualification:

                //Validamos que el cliente exista en el sistema: 
                $validate = Clientes::where('email', $request->input(key: 'email'))->first();

                if ($validate) {

                    try {

                        $client = new Cliente;

                        //Validamos la calificacion ingresada: 
                        $response = $client->makeQualification(qualification: $request->input(key: 'qualification'));

                        if ($response) {

                            //Registramos la calificacion en la DB: 
                        }
                    } catch (Exception $e) {
                        //Retornamos el error: 
                        return ['Error' => $e->getMessage()];
                    }
                } else {
                    //Retornamos el error: 
                    return ['Error' => 'No existe en el sistema.'];
                }

                break;

            default:
                return ['Error' => 'Formulario no valido.'];
                break;
        }
    }

    //Retorna la informacion del cliente solicitado: 
    public function show($email)
    {
        //Validamos que el cliente exista en el DB: 
        $model = Clientes::where('email', '=', $email)->first();

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
    public function update(Request $request)
    {
        $model = Clientes::where('email', '=', $request->input(key: 'email'));

        //Validamos que el usuario no exista en la DB: 
        $validate = $model->first();

        if ($validate) {

            //Instanciamos la clase 'Cliente' para procesar los datos: 
            $client = new Cliente(
                password: $request->input(key: 'newPassword'),
                confirmPassword: $request->input(key: 'confirmPassword'),
                telefono: $request->input(key: 'telefono')
            );

            //Almacenamos la instancia en una sesion para enviar los datos al trait 'MethodsUser': 
            $_SESSION['registerData'] = $client;

            $response = $client->registerData();

            if ($response) {

                try {

                    $insert = $request->except(['newPassword', 'confirmPassword']);
                    $insert['newPassword'] = $response['fields']['password'];
                    $insert['sesion']   = 'Inactiva';

                    //Realizamos la actualizacion en la DB: 
                    $model->update(['password' => $insert['newPassword'],
                                    'telefono' => $insert['telefono']]);

                    //Eliminamos el 'hash' de la password, por temas de seguirad:
                    unset($response['fields']['password']);
                    //Retornamos la respuesta: 
                    return $response;
                } catch (Exception $e) {
                    return ['register' => false, 'Error' => $e->getMessage()];
                }
            } else {

                return $response;
            }
        } else {

            return ['register' => false, 'Error' => 'No existe en el sistema.'];
        }

    }

    //Metodo para eliminar un cliente en especifico: 
    public function destroy($email)
    {
        $model = Clientes::where('email', '=', $email);

        //Validamos que el cliente exista en el DB: 
        $validate = $model->first();

        if ($validate) {

            try {
                //Eliminamos el Cliente de la DB:  
                $model->delete();
                //Retornamos la informacion del cliente: 
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
