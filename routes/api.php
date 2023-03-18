<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\VehiculoApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Auth Module
Route::post('login', [AuthApiController::class, 'signIn']);
Route::post('register', [AuthApiController::class, 'userRegister']);

// Vehicle Module
Route::post('vehiculo', [VehiculoApiController::class, 'vehicleRegister'])/* ->middleware(['jwt']) */;
