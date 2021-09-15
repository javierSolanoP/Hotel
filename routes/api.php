<?php

use Illuminate\Support\Facades\Route;

//Modulo cliente: 
Route::apiResource(name: '/clients', controller: 'App\Http\Controllers\Module_Client\API\ClienteController');
Route::apiResource(name: '/admin-root', controller: 'App\Http\Controllers\Module_Admin\API/RecepcionistaController');
Route::apiResource(name: '/admin-reception', controller: 'App\Http\Controllers\Module_Admin\API/RecepcionistaController');

