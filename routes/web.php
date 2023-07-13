<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;


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

    #Employee Routes admin can access
    Route::get('/employees',[UserController::class,'showEmployees'])->name('showEmployees');
    Route::delete('/employees/{id}/delete', [UserController::class,'destroy'])->name('Employees.delete');
    Route::get('/employees',[UserController::class,'showEmployees'])->name('showEmployees');
    Route::get('/employees/create',[UserController::class,'addEmployee'])->name('Employees.add');
    Route::post('/employees/store', [UserController::class,'store'])->name('Employees.store');

});
//emp logout
Route::get('/logout',[UserController::class,'logout'])->name('logout');


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

Route::get('/register',function(){
    return view('student.register_form');
})->name('register');


//Password

//got to reset password link for employees
Route::get('/forgot-password', function () {
    return view('emp.forgot-password');
})->middleware('guest')->name('password.request');

//employee enters email to send link of password
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

//after user clicks on link
Route::get('/reset-password/{token}', function (string $token) {
    return view('emp.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:5|confirmed',
    ]);
 
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PASSWORD_RESET
                ? redirect()->route('home')->with('status', __($status))
                : back()->withErrors(['status' => [__($status)]]);
})->middleware('guest')->name('password.update');
