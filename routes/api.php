<?php

use App\Http\Controllers\PetController;
use App\Http\Controllers\ShelterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->controller('AuthController')->group(function() {
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::post('', 'AuthController@authenticate');
});

# Routes of user password
Route::post('/user/password/forgot', 'PasswordController@forgot');
Route::post('/user/password/reset', 'PasswordController@reset');

Route::get('/states', 'StateController@index');
Route::get('/cities/{uf}', 'CityController@index');

Route::middleware('jwt.authenticate')->group(function () {
    Route::get('/users', 'UserController@index');
    Route::get('/user/{id}', 'UserController@show');
    Route::post('/user', 'UserController@store');
    Route::put('/user/{id}', 'UserController@update');
    Route::put('/user/{id}/change-password', 'PasswordController@change');

    Route::apiResources(['shelter' => ShelterController::class]);
    Route::apiResources(['pet' => PetController::class]);
    Route::get('/pet-types', 'PetController@fetchTypes');
});