<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\MaintenanceApiController;
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
Route::post('login'     , [AuthApiController::class, 'signIn'])->name('login');
Route::post('register'  , [AuthApiController::class, 'userRegister']);
Route::post('logout'    , [AuthApiController::class, 'logout'])->middleware(['auth:api']);

// Vehicle Module
Route::get('vehiculo/{vehicleId}'           , [VehiculoApiController::class, 'getVehicleById'])/* ->middleware(['auth:api']) */;
Route::get('vehiculos/{userId}'             , [VehiculoApiController::class, 'getVehiclesByUserId'])/* ->middleware(['auth:api']) */;
Route::post('vehiculo'                      , [VehiculoApiController::class, 'storeVehicle'])/* ->middleware(['auth:api']) */;
Route::post('vehiculo/update/{vehicleId}'   , [VehiculoApiController::class, 'updateVehicle'])/* ->middleware(['auth:api']) */;
Route::delete('vehiculo/{vehicleId}'        , [VehiculoApiController::class, 'deleteVehicle'])/* ->middleware(['auth:api']) */;

// Maintenance Module
Route::get('mantenimiento/{maintenanceId}'          , [MaintenanceApiController::class, 'getMaintenanceById'])/* ->middleware(['auth:api']) */;
Route::get('mantenimientos/{vehicleId}'             , [MaintenanceApiController::class, 'getMaintenancesByVehicleId'])/* ->middleware(['auth:api']) */;
Route::post('mantenimiento'                         , [MaintenanceApiController::class, 'storeMaintenance'])/* ->middleware(['auth:api']) */;
Route::post('mantenimiento/update/{maintenanceId}'  , [MaintenanceApiController::class, 'updateMaintenance'])/* ->middleware(['auth:api']) */;
Route::delete('mantenimiento/{maintenanceId}'       , [MaintenanceApiController::class, 'deleteMaintenance'])/* ->middleware(['auth:api']) */;
