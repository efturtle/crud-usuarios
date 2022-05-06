<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UserController::class)->group(function (){
    Route::get('v1/users', 'index');
    Route::post('v1/users/new', 'store');
    Route::delete('v1/users/delete/{user}', 'destroy');
    Route::put('v1/users/update/{user}', 'update');
    Route::get('v1/users/{user}', 'show');
});
