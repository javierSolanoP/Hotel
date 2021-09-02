<?php

namespace App\Http\Controllers\Module_Admin\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Module_Admin\Class\Administrador;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array('form'            => $request->all('form'),
                      'nombre'          => $request->all('nombre'),
                      'apellido'        => $request->all('apellido'),
                      'email'           => $request->all('email'),
                      'pasword'         => $request->all('password'),
                      'confirmPassword' => $request->all('confirmPassword'));

        $admin = new Administrador(nombre:          $data['nombre']['nombre'],
                                   apellido:        $data['apellido']['apellido'],
                                   email:           $data['email']['email'],
                                   password:        $data['password']['password'],
                                   confirmPassword: $data['confirmPassword']['confirmPassword']);

        $response = match($data['form']['form']){
            
            'registerData' => $admin->registerData(),
            default => 'Formulario no valido' 

        };

        return array('Response' => $response);

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
