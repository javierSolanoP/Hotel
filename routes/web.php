<?php

use App\Http\Controllers\Module_User\API\GoogleProviderController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Two\GoogleProvider;

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

Route::get('/auth-redirect/{url}/{urlFail}', [GoogleProviderController::class, 'redirect']);

Route::get('/google-callback', [GoogleProviderController::class,'receive']);

Route::get('/fail-auth', function () {
    return view('error');
});

Route::get('/profile', function () {
    return view('user-Profile');
});
