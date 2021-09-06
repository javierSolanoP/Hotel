<?php
namespace App\Http\Controllers\Require\Trait;

use App\Http\Controllers\Require\Class\Encrypte;
use Illuminate\Http\Request;
use App\Http\Controllers\Require\Class\Validate;
use App\Http\Controllers\Require\Mail\RestorePassword;
use App\Http\Controllers\Require\Trait\MethodsValidate;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Mail;

session_start();

//Los metodos de la clase usuario: 
trait MethodsUser {

    use MethodsValidate;

    //Registrar datos del usuario: 
    public function registerData()
    {
        $validate = new Validate;
        $valid = [];

        if(isset($_SESSION['registerData'])){

            $data = $_SESSION['registerData'];

            if(isset($data->cedula)){

                //Validamos el campo cedula: 
                if($validate->validateNumber($data->cedula)){

                    $valid['cedula'] = true;

                }else{

                    die('{"register": false, "Error": "Cedula: no puede contener datos alfanumericos."}');
                }
            }

            if(isset($data->nombre)){
                
                //Validamos el campo nombre: 
                if($validate->validateString($data->nombre)){
                    
                    $valid['nombre'] = true;

                }else{

                    die('{"register": false, "Error": "Nombre: no puede contener datos alfanumericos."}');
                }
            }

            if(isset($data->apellido)){
                
                 //Validamos el campo apellido: 
                if($validate->validateString($data->apellido)){

                    $valid['apellido'] = true;

                }else{

                    die('{"register": false, "Error": "Apellido: no puede contener datos alfanumericos."}');
                }
            }

            if(isset($data->genero)){
                
                 //Validamos el campo genero: 
                if($validate->validateString($data->genero)){

                    $valid['apellido'] = true;

                }else{

                    die('{"register": false, "Error": "Genero: no puede contener datos alfanumericos."}');
                }
            }


            if(isset($data->edad)){
                
                 //Validamos el campo edad: 
                if($validate->validateNumber($data->edad)){

                    $valid['edad'] = true;

                }else{

                    die('{"register": false, "Error": "Edad: no puede contener datos alfanumericos."}');
                }
            }

            if(isset($data->fecha_nacimiento)){
                
                //Validamos el campo fecha_nacimiento: 
                if($validate->validateNumber($data->fecha_nacimiento)){

                    $valid['fecha_nacimiento'] = true;

                }else{

                    die('{"register": false, "Error": "fecha_nacimiento: no puede contener datos alfanumericos."}');
                }
            }

            if(isset($data->email)){
                
                //Validamos el campo email: 
                if($validate->validateEmail($data->email)){

                    $valid['email'] = true;

                }else{

                    die('{"register": false, "Error": "email: no es un dato tipo email."}');
                }
            }

            if(isset($data->password) && isset($data->confirmPassword)){

                if($data->password == $data->confirmPassword){

                    $encrypte = new Encrypte;

                    $encryptePassword = $encrypte->encryptePassword($data->password);

                    if($encryptePassword){

                        $valid['password'] = $encryptePassword;

                    }else{

                        die('{"register": false, "Error": "La password y el hash no coinciden."}');
                    }

                }else{

                    die('{"register": false, "Error": "La passwords no coinciden."}');
                }
            }

            if(isset($data->telefono)){
                
                //Validamos el campo telefono: 
                if($validate->validateNumber($data->telefono)){

                    $valid['telefono'] = true;

                }else{

                    die('{"register": false, "Error": "email: no puede contener datos alfanumericos."}');
                }
            }

        }

        //Retornamos la respuesta:      
        try{
            return array('register' => true, 'fields' => $valid);
        }catch(Exception $e){
            return ['register' => false, 'Error' => $e->getMessage()];
        }
    }

    //Metodo para 'Iniciar sesion': 
    public function login()
    {
        $validate = new Validate;

        if(isset($_SESSION['login'])){

            //Validamos los datos ingresados: 
            try{

                $data = $_SESSION['login'];

                $login = $validate->validatePassword(password: $data->password, hash: $data->confirmPassword);

                if($login){
                    //Retornamos la respuesta: 
                    return ['login' => true];
                }else{
                    //Retornamos el error:
                    return ['login' => false, 'Error' => 'Password incorrecta.'];
                }

            }catch(Exception $e){
                //Retornamos el error: 
                return ['login' => false, 'Error' => $e->getMessage()];
            }

        }
    }

    //Metodo para restablecer contrasenia: 
    public function restorePassword($url, $user, $updated_at, $sessionStatus, $newPassword)
    {
        //Estado de sesiones: 
        static $inactive = 'Inactiva'; 
        static $pending  = 'Pendiente';

        //Validamos que el usuario no haya iniciado sesion o haya hecho una solicitud de restablecimiento con anterioridad: 
        if($sessionStatus == $inactive){

            try{

                //Declaramos la ruta del cliente, a la cual se va redirigir el usuario: 
                view('restorePassword');
    
                //Enviamos el correo de restablecimiento: 
                $restorePassword = new RestorePassword(url: $url);
                Mail::to($user)->send($restorePassword);

                //Retornamos la respuesta: 
                return ['restorePassword' => true];
    
            }catch(Exception $e){
                //Retornamos el error: 
                return ['restorePassword' => false, 'Error' => $e->getMessage()];
            }

        }elseif($sessionStatus == $pending){

            //Fecha actual en la que se realiza la peticion: 
            $currentDate = new DateTime;

            //Fecha de expiracion para poder restablecer la contrasenia: 
            $dateOfExpire = date('Y-m-d H:i:s', strtotime($updated_at.'+10 minutes'));

            //Validamos si el usuario esta intentando restablecer la contrasenia, durante el tiempo permitido: 
            if($currentDate->format('Y-m-d H:i:s') <= $dateOfExpire){

                //Encryptamos la nueva contrasenia: 
                $encrypte = new Encrypte;
                $encryptePassword = $encrypte->encryptePassword(password: $newPassword);
                //Retornamos la respuesta: 
                return ['restorePassword' => true, 'newPassword' => $encryptePassword];

            }elseif($currentDate->format('Y-m-d H:i:s') > $dateOfExpire){

                //Retornamos el error: 
                return ['restorePassword' => false, 'Error' => 'Ha excedido el tiempo limite de espera.'];

            }

        }else{

            //Retornamos el error:
            return ['restorePassword' => false, 'Error' => 'El usuario ya inicio sesion en el sistema.'];
        }

    }


    //Realizar una reservacion: 
    public function makeReservation()
    {}

}