<?php
namespace App\Http\Controllers\Require\Trait;

session_start();

//Los metodos de la clase usuario: 
trait MethodsUser {

    //Registrar datos del usuario: 
    public function registerData()
    {}

    //Realizar una reservacion: 
    public function makeReservation()
    {}

}