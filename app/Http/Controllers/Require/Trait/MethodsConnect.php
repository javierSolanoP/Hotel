<?php
namespace App\Http\Controllers\Require\Trait;
use App\Http\Controllers\Require\Connect\Conector;

//Metodos de la clase 'Conector': 
trait MethodsConnect {

    //Crear una conexion: 
    public function receiveConnect($data)
    {

        $connect = new Conector;
        $connect->receiveData($data);
        $_SESSION['connect'] = $connect;

    }

    //Entregar datos de la conexion: 
    public function deliverConnect()
    {
        if(isset($_SESSION['connect'])){

            $connect = $_SESSION['connect'];
            return $connect->deliverData();

        }
    }

}