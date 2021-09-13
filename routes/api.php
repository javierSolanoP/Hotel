<?php

use Illuminate\Support\Facades\Route;

//Modulo cliente: 
Route::apiResource(name: '/clients', controller: 'App\Http\Controllers\Module_Client\API\ClienteController');



