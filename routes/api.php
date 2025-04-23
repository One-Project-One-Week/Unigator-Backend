<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\UniversityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'userRegister']);
Route::post('/university/register', [AuthController::class, 'uniRegister']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/university/{slug}', [UniversityController::class, 'detail']);
});

Route::apiResource('/programs', ProgramController::class);

Route::get('/university', UniversityController::class, 'all');
Route::get('/university/top', [UniversityController::class, 'topUniversities']);
