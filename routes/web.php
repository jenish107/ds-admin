<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Employ;

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
    Route::get('/show-companies-form/{id?}', [CompanyController::class, 'showCompaniesForm'])->name('showCompaniesForm');
    Route::post('/add-companies', [CompanyController::class, 'createCompanies'])->name('addCompanies');
    Route::put('/update-companies', [CompanyController::class, 'updateCompanies'])->name('updateCompanies');
    Route::delete('/delete-companies/{id}', [CompanyController::class, 'deleteCompanies'])->name('deleteCompanies');

    //-----department ----
    Route::get('/get-all-department/{companyId}', [DepartmentController::class, 'allDepartment'])->name('getAllDepartment');
    Route::get('/department-data/{companyId}', [DepartmentController::class, 'showDepartment'])->name('showAllDepartment');
    Route::get('/show-department-form/{companyId}/{id?}', [DepartmentController::class, 'showDepartmentForm'])->name('showDepartmentForm');
    Route::post('/add-department', [DepartmentController::class, 'createDepartment'])->name('addDepartment');
    Route::put('/update-department', [DepartmentController::class, 'updateDepartment'])->name('updateDepartment');
    Route::delete('/delete-department/{id}', [DepartmentController::class, 'deleteDepartment'])->name('deleteDepartment');

    //-----employ ----
    Route::get('/get-all-employ/{departmentId}', [EmployController::class, 'allEmploy'])->name('getAllEmploy');
    Route::get('/employ-data/{departmentId}', [EmployController::class, 'showEmploy'])->name('showAllEmploy');
    Route::get('/show-employ-form/{departmentId}/{id?}', [EmployController::class, 'showEmployForm'])->name('showEmployForm');
    Route::post('/add-employ', [EmployController::class, 'createEmploy'])->name('addEmploy');
    Route::put('/update-employ', [EmployController::class, 'updateEmploy'])->name('updateEmploy');
    Route::delete('/delete-employ/{id}', [EmployController::class, 'deleteEmploy'])->name('deleteEmploy');

    //-----family ----
    Route::get('/get-all-family/{employId}', [FamilyController::class, 'allFamily'])->name('getAllFamily');
    Route::get('/family-data/{employId}', [FamilyController::class, 'showFamily'])->name('showAllFamily');
    Route::get('/show-family-form/{employId}/{id?}', [FamilyController::class, 'showFamilyForm'])->name('showFamilyForm');
    Route::post('/add-family', [FamilyController::class, 'createFamily'])->name('addFamily');
    Route::put('/update-family', [FamilyController::class, 'updateFamily'])->name('updateFamily');
    Route::delete('/delete-family/{id}', [FamilyController::class, 'deleteFamily'])->name('deleteFamily');

    //-----invoice---
    Route::controller(InvoiceController::class)->group(function () {
        Route::prefix('/invoice')->group(function () {
            Route::get('/get-products', 'getProduct')->name('getProduct');
            Route::get('/list', 'invoiceList')->name('showInvoiceList');
            Route::get('/get-list', 'getAllInvoice')->name('getAllInvoice');
            Route::get('/form/{id?}', 'showInvoiceForm')->name('showInvoiceForm');
            Route::post('/add', 'addInvoice')->name('addInvoice');
            Route::put('/update', 'updateInvoice')->name('updateInvoice');
            Route::delete('/delete/{id}', 'deleteInvoice')->name('deleteInvoice');
        });
    });

    //---product-----
    Route::controller(ProductController::class)->group(function () {
        Route::prefix('/product')->group(function () {
            Route::get('/list', 'productList')->name('showProductList');
            Route::get('/get-list', 'getAllProduct')->name('getAllProduct');
            Route::get('/form/{id?}', 'showProductForm')->name('showProductForm');
            Route::post('/add', 'addProduct')->name('addProduct');
            Route::put('/update', 'updateProduct')->name('updateProduct');
            Route::delete('/delete/{id}', 'deleteProduct')->name('deleteProduct');
        });
    });
});
