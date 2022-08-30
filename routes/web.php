<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthOtpController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DesignerController;
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

Route::get('/', function () {
    return view('auth.login');
});
Route::middleware(['middleware' => 'PreventBackHistory'])->group(function () {
    Auth::routes();
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'admin', 'middleware' => ['isAdmin', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});


Route::group(['prefix' => 'user', 'middleware' => ['isUser', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [UserController::class, 'index'])->name('user.dashboard');
    
});

Route::group(['prefix' => 'designer', 'middleware' => ['isDesigner', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [DesignerController::class, 'index'])->name('designer.dashboard');
});

Route::controller(AuthOtpController::class)->group( function(){
Route::get('otp/login','login')->name('otp.login');
Route::post('/otp/generate','generate')->name('otp.generate');
Route::get('/otp/verification', 'verification')->name('otp.verification');
Route::post('/otp/login', 'loginWithOtp')->name('otp.getlogin');
});

//Google login
Route::get('login/google',[LoginController::class,'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback',[LoginController::class,'handleGoogleCallback']);


//Facebook login
Route::get('login/facebook',[LoginController::class,'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback',[LoginController::class,'handleFacebookCallback']);