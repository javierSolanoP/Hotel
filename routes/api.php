<?php

use Illuminate\Support\Facades\Route;

//Modulo cliente: 
Route::apiResource(name: '/clients', controller: 'App\Http\Controllers\Module_Client\API\ClienteController');

//Modulo usuarios:
Route::apiResource(name: '/login', controller: 'App\Http\Controllers\Module_User\API\LoginController');
Route::apiResource(name:'/roles', controller: 'App\Http\Controllers\Module_User\API\RoleController');
Route::apiResource(name: '/permissions', controller: 'App\Http\Controllers\Module_User\API\PermisosController');