<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\IndustryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(LoginController::class)
    ->as("admin.")
    ->group(function () {
        Route::get("/", "login")->name("login");
        Route::post("/logincheck", "loginCheck")->name("loginCheck");
        Route::get("/logout", "logout")->name("logout");
    });

Route::name("admin.")
    ->middleware("auth")
    ->group(function () {
        Route::get("/home", [HomeController::class, "index"])->name("home");
        Route::resources([
            'employee'      => EmployeeController::class,
            'company'       => CompanyController::class,
            'industries'    => IndustryController::class
        ]);
    });
