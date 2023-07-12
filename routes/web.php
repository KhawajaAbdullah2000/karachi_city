<?php

use App\Http\Controllers\StudentController;
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
    Route::get('/logout',[UserController::class,'logout'])->name('logout');

    #Employee Routes
    Route::get('/employees',[UserController::class,'showEmployees'])->name('showEmployees');
    Route::delete('/employees/{id}/delete', [UserController::class,'destroy'])->name('Employees.delete');
    Route::get('/employees',[UserController::class,'showEmployees'])->name('showEmployees');
    Route::get('/employees/create',[UserController::class,'addEmployee'])->name('Employees.add');
    Route::post('/employees/store', [UserController::class,'store'])->name('Employees.store');

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


//student login
Route::middleware(['auth:student','isstudent'])->group(function(){
    Route::get('/student_home',[StudentController::class,'student_home'])->name('student_home');
Route::get('/student_logout',[StudentController::class,'logout'])->name('student_logout');

});



Route::get('/student/login',function(){
    return view('student.loginform');
})->name('student_login');

Route::post('/student/login',[StudentController::class,'login'])->name('student_login_logic');



Route::post('login',[UserController::class,'login']);





//Route::get('changepass',[UserController::class,'changepass']);