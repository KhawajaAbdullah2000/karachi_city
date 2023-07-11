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

//admin can only access
Route::middleware(['auth','isadmin'])->group(function(){
    Route::get('/admin_home',function(){
        return view('admin.admin_home');
    })->name('admin_home');
});


//employees and not admin can access
Route::middleware(['auth','isemp'])->group(function(){
    Route::get('/emp_home',function(){
        return view('emp.emp_home');
    })->name('emp_home');
    
});



Route::get('/', function () {
    return view('home');
})->middleware('home')->name('home');

Route::get('/login_form',function(){
    return view('login_form');
})->middleware('guest')->name('login_form');


Route::post('login',[UserController::class,'login']);
Route::get('/logout',[UserController::class,'logout'])->name('logout');
Route::get('/employees',[UserController::class,'showEmployees'])->name('showEmployees');


//Route::get('changepass',[UserController::class,'changepass']);