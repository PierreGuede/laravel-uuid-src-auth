<?php


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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', ["App\src\Auths\Controllers\AuthController", 'me']);
    Route::put('/update-password/{uuid}', ["App\src\Auths\Controllers\AuthController", 'updatePassword']);
    Route::post('/log-out', ["App\src\Auths\Controllers\AuthController", 'logOut']);
});

Route::prefix('auth')->group(function () {
    Route::post('/register', ["App\src\Auths\Controllers\AuthController", 'register']);
    Route::post('/login', ["App\src\Auths\Controllers\AuthController", 'login']);
    Route::post('/reset-password', ["App\src\Auths\Controllers\AuthController", 'findByMail']);
    Route::post('/reset-password-code', ["App\src\Auths\Controllers\AuthController", 'resetPassword']);
    // Route::post('/logout', ["App\Http\Controllers\AuthController", 'logout']);
    // Route::get('/email/verify/{id}/{hash}', "App\Http\Controllers\VerifyEmailController")
    // ->middleware(['auth:sanctum', 'signed'])->name('verification.verify');
    // Route::post('/email/verification-notification', "App\Http\Controllers\SendMailVerificationController")
    // ->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
});
