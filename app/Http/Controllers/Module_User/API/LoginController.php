<?php

namespace App\Http\Controllers\Module_User\API;

use App\Http\Controllers\Controller;
use App\Http\controllers\Module_User\API\UsuariosController;
use App\Http\Controllers\Module_User\Class\Usuario;
use App\Models\Usuarios;
use Exception;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        $userController = new UsuariosController;
        return $userController->store(email: 'jmspfh@gmail.com', 
                                     cedula: "16546687",
                                     nombre: "JAVIER",
                                     apellido: "SOLANO",
                                     genero: "MASCULINO",
                                     edad: "19",
                                     fecha_nacimiento: "2002-01-08",
                                     password: "12345JAVIERSOLAN",
                                     confirmPassword: "12345JAVIERSOLANO",
                                     telefono: "3245897845",
                                     role: "cliente");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Formulario de la peticion: 
        $form = $request->input(key: 'form');

        //Tipos de formularios: 

        //Formulario de inicio de sesion de cliente: 
        static $login           = 'login';

        //Formulario de restablecimiento de contrasenia, cliente: 
        static $restorePassword = 'restorePassword';

        //Formulario de cerrar sesion de cliente: 
        static $closeLogin      = 'closeLogin';

        switch($form){

            case $login: 

                $model = Usuarios::where('email', '=', $request->input(key: 'email'));

                //Validamos que el usuario exista en la DB: 
                $validate = $model->first();

                if ($validate) {

                    //Validamos que el usuario no tenga una sesion activa en el sistema: 
                    if ($validate['sesion'] == 'Inactiva') {

                        //Extraemos el 'hash' del cliente, para hacer la validacion: 
                        $confirmPassword = $validate['password'];

                        //Instanciamos la clase 'Cliente' para procesar los datos:
                        $client = new Usuario(
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

                $model = Usuarios::where('email', '=', $request->input(key: 'email'));

                //Validamos que el usuario exista en la DB: 
                $validate = $model->first();

                //Estado de sesiones: 
                static $inactive = 'Inactiva';
                static $pending  = 'Pendiente';

                if ($validate) {

                    $client = new Usuario(
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

                $model = Usuarios::where('email', '=', $request->input(key: 'email'));

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

                default:
                return ['Error' => 'Formulario no valido.'];
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
