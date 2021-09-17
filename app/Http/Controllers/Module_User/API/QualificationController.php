<?php

namespace App\Http\Controllers\Module_User\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Module_User\Class\Usuario;
use App\Models\Usuarios;
use Exception;
use Illuminate\Http\Request;

class QualificationController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //Validamos que el cliente exista en el sistema: 
        $validate = Usuarios::where('email', $request->input(key: 'email'))->first();

        if ($validate) {

            try {

                $client = new Usuario;

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
