<?php

use App\Http\Controllers\Module_Client\Web\GoogleProviderController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/redirect', [GoogleProviderController::class,'index']);

Route::get('/google-callback', [GoogleProviderController::class,'store']);

Route::get('/profile', function () {
    return view('user-Profile');
});