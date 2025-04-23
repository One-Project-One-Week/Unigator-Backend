<?php

use App\Http\Controllers\AccomodationController;
use App\Http\Controllers\ProgramController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/programs', ProgramController::class);


Route::post('/accomodation', [AccomodationController::class, 'createAccomodation']);

Route::put('/accomodation/{id}', [AccomodationController::class, 'updateAccomodation']);

Route::delete('/accomodation/{id}', [AccomodationController::class, 'deleteAccomodation']);