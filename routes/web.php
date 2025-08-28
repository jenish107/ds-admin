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

Route::get('/change-password', [UserController::class, 'changePassword'])->name('changePasswordPage');
Route::put('/check/change-password', [UserController::class, 'checkChangePassword'])->name('checkChangePassword');

Route::get('/forget-password-page', [UserController::class, 'forgetPasswordPage'])->name('forgetPasswordPage');
Route::post('/forget-password-form', [UserController::class, 'forgetPasswordForm'])->name('forgetPasswordForm');
Route::get('/forget-password-otp-page', [UserController::class, 'forgetPasswordOtpPage'])->name('forgetPasswordOtpPage');
Route::post('/new-password-form', [UserController::class, 'newPasswordForm'])->name('newPasswordForm');
Route::put('/new-password', [UserController::class, 'newPassword'])->name('newPassword');

Route::get('/get-img', [UserController::class, 'fetchImg'])->name('getImg');
Route::get('/get-countries', [UserController::class, 'fetchCountry'])->name('getCountries');
Route::get('/get-state/{id}', [UserController::class, 'fetchState'])->name('getState');
Route::get('/get-city/{id}', [UserController::class, 'fetchCity'])->name('getCity');
