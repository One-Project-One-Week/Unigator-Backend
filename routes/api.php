<?php

use App\Http\Controllers\AccomodationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProgramController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UniversityController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/programs', ProgramController::class);


Route::post('/register', [AuthController::class, 'userRegister']);
Route::post('/university/register', [AuthController::class, 'uniRegister']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/university', [UniversityController::class, 'allUniversities']);
Route::get('/university/top', [UniversityController::class, 'topUniversities']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::put('/university/update', [UniversityController::class, 'updateInfo'])->middleware('university');
    Route::get('/university/{slug}', [UniversityController::class, 'detail']);
    Route::get('/university/dashboard', [UniversityController::class, 'dashboard'])->middleware('university');
});

Route::apiResource('/programs', ProgramController::class);
Route::apiResource('/categories', CategoryController::class);


Route::post('/accomodation', [AccomodationController::class, 'createAccomodation']);

Route::put('/accomodation/{id}', [AccomodationController::class, 'UpdateAccomodation']);

Route::delete('/accomodation/{id}', [AccomodationController::class, 'deleteAccomodation']);


Route::get('/rating', [RatingController::class, 'getRating']);
Route::post('/rating', [RatingController::class, 'createRating']);
