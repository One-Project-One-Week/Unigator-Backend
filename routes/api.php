<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\AccomodationController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/accomodation', [AccomodationController::class, 'createAccomodation']);


Route::post('/register', [AuthController::class, 'userRegister']);
Route::post('/university/register', [AuthController::class, 'uniRegister']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/university', [UniversityController::class, 'allUniversities']);
Route::get('/university/top', [UniversityController::class, 'topUniversities']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::put('/university/update', [UniversityController::class, 'updateInfo']);
    Route::get('/university/{slug}', [UniversityController::class, 'detail']);

});

Route::apiResource('/programs', ProgramController::class);
Route::apiResource('/categories', CategoryController::class);




Route::put('/accomodation/{id}', [AccomodationController::class, 'UpdateAccomodation']);

<<<<<<< HEAD
Route::delete('/accomodation/{id}', [AccomodationController::class, 'deleteAccomodation']);

=======
Route::delete('/accomodation/{id}', [AccomodationController::class, 'deleteAccomodation']);
>>>>>>> 6a67277d0e60a757fd53f31822a921f89f98d5fd
