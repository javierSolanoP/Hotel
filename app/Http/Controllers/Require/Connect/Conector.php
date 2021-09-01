<?php
namespace App\Http\Controllers\Require\Connect;

//La clase conectora de los modulos: 
class Conector {

    private $data;

    public function receiveData($data)
    {
        $this->data = $data;
    }

    public function deliverData()
    {
        return $this->data;
    }

}