<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

//auth
Route::get('/registration-page', [AuthController::class, 'registrationPage'])->name('registrationPage');
Route::post('/registration', [AuthController::class, 'registration'])->name('registration');

Route::get('/otp-page', [AuthController::class, 'otpPage'])->name('otpPage');
Route::post('/confirm-otp', [AuthController::class, 'confirmOtp'])->name('confirmOtp');

Route::get('/login-page', [AuthController::class, 'loginPage'])->name('loginPage');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('IsLogin')->group(function () {
    Route::get('/dashboard-page', [AuthController::class, 'dashboardPage'])->name('dashboardPage');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

//user

Route::get('/dashboard-page/profile', [UserController::class, 'index'])->name('editProfilePage');
Route::put('/dashboard-page/update-profile', [UserController::class, 'updateProfile'])->name('updateProfile');

Route::get('/get-countries', [UserController::class, 'fetchCountry'])->name('getCountries');
Route::get('/get-state/{id}', [UserController::class, 'fetchState'])->name('getState');
Route::get('/get-city/{id}', [UserController::class, 'fetchCity'])->name('getCity');
