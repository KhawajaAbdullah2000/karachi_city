<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::get('/login_form',function(){
    return view('login_form');
})->name('login_form');

Route::get('/admin_home',function(){
    return view('admin.admin_home');
})->name('admin_home');

Route::get('/emp_home',function(){
    return view('emp.emp_home');
})->name('emp_home');

Route::post('login',[UserController::class,'login']);

Route::get('changepass',[UserController::class,'changepass']);