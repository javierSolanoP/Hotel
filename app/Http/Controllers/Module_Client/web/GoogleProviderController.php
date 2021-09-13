<?php

namespace App\Http\Controllers\Module_Client\Web;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Exception;
use Laravel\Socialite\Facades\Socialite;

class GoogleProviderController extends Controller
{
    public function index()
    {
        return Socialite::driver('google')->redirect();
    }

    public function store()
    {
        $user = Socialite::driver('google')->user();

        $model = Clientes::where('email', $user->email);
        $validate = $model->first();

        //Estados de sesion: 
        static $active   = 'Activa';
        static $inactive = 'Inactiva';
        if($validate){  

            if($validate['sesion'] == $inactive){
                try{
                    $model->update(['avatar' => $user->avatar_original,
                                    'sesion' => $active]);
                }catch(Exception $e){
                    echo $e->getMessage();
                }
            }else{
                return ['login' => false, 'Error' => 'Ya inicio sesion en el sistema.'];
            }
        }else{
            return ['login' => false, 'Error' => 'No existe en el sistema.'];
        }
    }
}