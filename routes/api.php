<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AccomodationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'userRegister']);
Route::post('/university/register', [AuthController::class, 'uniRegister']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

});
Route::apiResource('/programs', ProgramController::class);
Route::apiResource('/programs', ProgramController::class);


Route::post('/accomodation', [AccomodationController::class, 'createAccomodation']);

Route::put('/accomodation/{id}', [AccomodationController::class, 'updateAccomodation']);

Route::delete('/accomodation/{id}', [AccomodationController::class, 'deleteAccomodation']);