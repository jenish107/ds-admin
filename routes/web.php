<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
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

    // Route::get('/get-img', [UserController::class, 'fetchImg'])->name('getImg');
    Route::get('/get-countries', [UserController::class, 'fetchCountry'])->name('getCountries');
    Route::get('/get-state/{id}', [UserController::class, 'fetchState'])->name('getState');
    Route::get('/get-city/{id}', [UserController::class, 'fetchCity'])->name('getCity');

    //-----------user data ------
    Route::get('/get-all-user', [UserController::class, 'allUser'])->name('getAllUser');
    Route::get('/user-data', [UserController::class, 'showUser'])->name('showAllUser');
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');
    Route::get('/show-update-user/{id}', [UserController::class, 'showUpdateUser'])->name('showUpdateUser');
    Route::put('/update-user', [UserController::class, 'UpdateUser'])->name('UpdateUser');

    //-----companies ----
    Route::get('/get-all-companies', [CompanyController::class, 'allCompanies'])->name('getAllCompanies');
    Route::get('/companies-data', [CompanyController::class, 'showCompanies'])->name('showAllCompanies');
    Route::get('/show-companies-form', [CompanyController::class, 'showCompaniesForm'])->name('showCompaniesForm');
    Route::post('/add-companies', [CompanyController::class, 'createCompanies'])->name('addCompanies');
    Route::get('/show-update-companies-form/{id}', [CompanyController::class, 'showUpdateCompaniesForm'])->name('showUpdateCompaniesForm');
    Route::put('/update-companies', [CompanyController::class, 'updateCompanies'])->name('updateCompanies');
    Route::get('/search-companies/{name}', [CompanyController::class, 'searchCompanies'])->name('searchCompanies');
    Route::delete('/delete-companies/{id}', [CompanyController::class, 'deleteCompanies'])->name('deleteCompanies');

    //-----department ----
    Route::get('/get-all-department/{companyId}', [DepartmentController::class, 'allDepartment'])->name('getAllDepartment');
    Route::get('/department-data/{companyId}', [DepartmentController::class, 'showDepartment'])->name('showAllDepartment');
    Route::get('/show-department-form/{companyId}', [DepartmentController::class, 'showDepartmentForm'])->name('showDepartmentForm');
    Route::post('/add-department', [DepartmentController::class, 'createDepartment'])->name('addDepartment');
    Route::get('/show-update-department-form/{id}/{companyId}', [DepartmentController::class, 'showUpdateDepartmentForm'])->name('showUpdateDepartmentForm');
    Route::put('/update-department', [DepartmentController::class, 'updateDepartment'])->name('updateDepartment');
    Route::get('/search-department/{name}', [DepartmentController::class, 'searchDepartment'])->name('searchDepartment');
    Route::delete('/delete-department/{id}', [DepartmentController::class, 'deleteDepartment'])->name('deleteDepartment');
});
