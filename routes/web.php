<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ZktecoController;
use App\Http\Controllers\AttendanceController;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\Student;
use App\Models\leaves;
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
    Route::get('/employees',[UserController::class,'showEmployees'])->name('showEmployees');
    Route::delete('/employees/{id}/delete', [UserController::class,'destroy'])->name('Employees.delete');
    Route::get('/employees/create',[UserController::class,'addEmployee'])->name('Employees.add');
    Route::post('/employees/store', [UserController::class,'store'])->name('Employees.store');
    Route::get('/employees/{id}/update',[UserController::class,'editEmployee'])->name('Employees.update');
    Route::put('/employees/{id}/edit',[UserController::class,'updateEmployee'])->name('Employees.edit');
    Route::get('employees/{id}/display',[UserController::class,'viewEmployee'])->name('Employees.view');

    Route::get('/Branches',[BranchController::class,'showbranches'])->name('branches.show');
    Route::delete('/Branches/delete', [BranchController::class,'destroy'])->name('branches.delete');
    Route::get('/Branches/create',[BranchController::class,'create'])->name('branches.create');
    Route::post('/Branches/store', [BranchController::class,'store'])->name('branches.store');

    Route::get('/Branches/{id}/edit',[BranchController::class,'edit'])->name('branches.edit');
    Route::put('/Branches/{id}/update',[BranchController::class,'update'])->name('branches.update');

    Route::get('/Branches/{id}/details',[ExpenseController::class,'showDetails'])->name('branches.details');
    Route::get('/expenses_home_monthly/{id}',[ExpenseController::class,'MonthlyShow'])->name('MonthlyShow');
    Route::get('/expenses_home_yearly/{id}',[ExpenseController::class,'yearlyShow'])->name('yearlyShow');
    Route::get('/expenses_home_details/{branch_id}/{month}',[ExpenseController::class,'ShowMonthlyDetails'])->name('MonthlyDetails');
    Route::get('/monthlyRevenue/{id}',[ExpenseController::class,'ShowMonthlyFees'])->name('showMonthlyFees');
    Route::get('/yearlyRevenue/{id}',[ExpenseController::class,'ShowYearlyFees'])->name('showYearlyFees');
    Route::get('/monthlyAdmissionRevenue/{id}',[ExpenseController::class,'ShowMonthlyAFees'])->name('showMonthlyAFees');
    Route::get('/yearlyAdmissionRevenue/{id}',[ExpenseController::class,'ShowYearlyAFees'])->name('showYearlyAFees');
    Route::get('/q1',[ExpenseController::class,'showqauterly'])->name('showquaterly');
    Route::get('/q2',[ExpenseController::class,'showqauterly1'])->name('showquaterly1');
    Route::get('/q3',[ExpenseController::class,'showqauterly2'])->name('showquaterly2');
    Route::get('/Y',[ExpenseController::class,'showTheFinal'])->name('Final');

    Route::get('/employees/{id}/leaves',[LeavesController::class,'showLeaves'])->name('leaves.show');
    Route::put('/employees/{l_id}/approve',[LeavesController::class,'approveLeave'])->name('leaves.approve');

    Route::get('make_announcement',[UserController::class,'make_announcement'])->name('make_announcement');
    Route::post('make_announcement',[UserController::class,'create_announcement'])->name('create_announcement');
    Route::get('announcements',[UserController::class,'announcements'])->name('announcements');
    Route::get('edit_announcement/{id}',[UserController::class,'edit_announcement']);
    Route::post('edit_announcement/{id}',[UserController::class,'submit_edit_announcement']);
    Route::delete('delete_announcement/{id}',[UserController::class,'destroy_announcement']);

    Route::get('/zktecoDevices',[ZktecoController::class,'showDevices'])->name('showDevices');


    //all registered students
    Route::get('all_registered_students',[UserController::class,'all_registered_students'])->name('all_registered_students');

//send invoice after collecting data from admin
route::post('send_registeration_invoice/{id}',[UserController::class,'send_registeration_invoice']);

    //go to registeraton invoice form
    Route::get('student_admission_invoice/{id}',[UserController::class,'student_admission_invoice']);

    //confirm payment view
    route::get('student_admission_fees_paid/{id}',[UserController::class,'student_admission_fees_paid']);



    route::post('add_registeration_fees/{id}',[UserController::class,'add_registeration_fees']);

    //all enrolled students
    Route::get('all_enrolled_students',[UserController::class,'all_enrolled_students'])->name('all_enrolled_students');

    //monthly fee invoice form view
    route::get('student_monthly_invoice/{id}',[UserController::class,'student_monthly_invoice']);

    //send invoice after collecting data from admin for monthly
route::post('send_monthly_invoice/{id}',[UserController::class,'send_monthly_invoice']);

//confirm monthly payment gormview
route::get('student_monthly_fees_paid/{id}',[UserController::class,'student_monthly_fees_paid']);
route::post('add_monthly_fees/{id}',[UserController::class,'add_monthly_fees']);

route::get('fees_this_month',[UserController::class,'fees_this_month']);





});
//emp logout
Route::get('/logout',[UserController::class,'logout'])->name('logout');




//employees and not admin can access
Route::middleware(['auth','isemp'])->group(function(){
    Route::get('/emp_home/{id}',[UserController::class,'displayEmployee'])->name('emp_home');
    Route::get('/emp_home/{id}/edit',[UserController::class,'editEmp'])->name('emp_edit');
    Route::put('/emp_home/{id}/update',[UserController::class,'updateEmp'])->name('emp_update');
    Route::get('/emp_home/{id}/branchDetails',[UserController::class,'branchDetail'])->name('emp_showBranch');
    Route::get('/emp_home/{id}/leaves',[LeavesController::class,'myLeaves'])->name('emp_myLeaves');
    Route::get('/emp_home/{id}/applyLeave',[LeavesController::class,'leaveForm'])->name('emp_applyLeave');
    Route::post('/emp_home/{id}/store',[LeavesController::class,'leavestore'])->name('emp_storeLeave');
    });

//For managers
Route::middleware(['auth','isemp','role:manager'])->group(function(){
    Route::get('registered_students/{branch_id}',[UserController::class,'registered_students'])->name('registered_students');
    Route::get('enrolled_students/{branch_id}',[UserController::class,'enrolled_students'])->name('enrolled_students');
  //  Route::get('/student_admission_fees_paid/{id}/{branch_id}',[UserController::class,'student_admission_fees_paid']);
    Route::get('/emp_items/{id}',[ItemController::class,'emp_items'])->name('emp_items');
    Route::get('/emp_items/{id}/add',[ItemController::class,'items_add'])->name('items_add');
    Route::post('/emp_items/{id}/store',[ItemController::class,'items_store'])->name('items_store');
    Route::get('/emp_items/{id}/update',[ItemController::class,'items_edit'])->name('items_edit');
    Route::put('/emp_id/{id}/edit',[ItemController::class,'items_update'])->name('items_update');
    Route::delete('/emp_items/{id}/delete',[ItemController::class,'items_destroy'])->name('items_delete');

    Route::get('/emp_borrow/{id}',[BorrowController::class,'borrowed'])->name('borrowed_items');
    Route::get('/emp_items/{id}/borrow',[BorrowController::class,'borrow_item'])->name('borrow_item');
    Route::post('/emp_items/{id}/addborrow',[BorrowController::class,'add_borrow'])->name('borrow_add');
    Route::delete('/emp_borrow/{id}/delete',[BorrowController::class,'destroy'])->name('borrow_delete');


    Route::get('/expenses_home/{id}',[ExpenseController::class,'Show'])->name('expenses_display');
    Route::get('/expenses_home/{id}/add',[ExpenseController::class,'expenseAdd'])->name('expenses_add');
    Route::post('/expenses_home/{id}/store',[ExpenseController::class,'store'])->name('expense_store');

    Route::get('/expenses_home/{id}/{branch_id}/edit',[ExpenseController::class,'edit'])->name('expenses_edit');
    Route::put('/expenses_home/{id}/{branch_id}/update',[ExpenseController::class,'update'])->name('expenses_update');

    Route::delete('/expenses_home/delete', [ExpenseController::class,'destroy'])->name('expenses_delete');

    //monthly


    Route::get('check_monthly_fees_current/{branch_id}',[UserController::class,'check_monthly_fees_current'])->name('check_monthly_fees_current');
   Route::get('paid_monthly_fees/{id}/{branch_id}',[UserController::class,'paid_monthly_fees'])->name('paid_monthly_fees');
Route::get('monthly_fees_record/{id}',[UserController::class,'monthly_fees_record'])->name('monthly_fees_record');
Route::get('pay_previous_fees/{id}/{month}/{year}',[UserController::class,'pay_previous_fees'])->name('pay_previous_fees');
Route::get('add_new_cash_payment/{branch_id}',[UserController::class,'add_new_cash_payment']);
Route::post('add_cash_record_monthly',[UserController::class,'add_cash_record_monthly']);

Route::get('delete_student/{id}',[UserController::class,'delete_student']);

Route::get('/emp_home/{id}/device',[ZktecoController::class,'manshowDevice'])->name('emp.showDevices');
Route::get('/zktecoDevice/create',[ZktecoController::class,'createDevice'])->name('createDevice');
Route::post('/zktecoDevice/{b_id}/store',[ZktecoController::class,'storeDevice'])->name('storeDevice');
Route::put('/zkTeco/{id}/Connect',[ZktecoController::class,'connect'])->name('connectDevice');
Route::get('/zkTeco/{id}/test',[ZktecoController::class,'test'])->name('testDevice');
Route::get('/zkteco/{id}/addStudents',[ZktecoController::class,'addStudents'])->name('addStudentsToDevice');
Route::get('/zkteco/{id}/getAttendance',[ZktecoController::class,'addAttendanceLogs'])->name('addAttendance');
Route::get('/emp_home/{id}/studentAttendance',[AttendanceController::class,'displayAttendance'])->name('showAttendance');
Route::put('/zkTeco/{id}/Disconnect',[ZktecoController::class,'disconnect'])->name('disconnectDevice');

});




Route::get('/', function () {
    return view('home');
})->middleware('home')->name('home');

Route::get('/login_form',function(){
    return view('login_form');
})->middleware('guest')->name('login_form');


//student
Route::middleware(['auth:student','isstudent'])->group(function(){
Route::get('/student_home',[StudentController::class,'student_home'])->name('student_home');
Route::get('/student_logout',[StudentController::class,'logout'])->name('student_logout');
Route::get('student_edit_form/{id}',[StudentController::class,'student_edit_form'])->name('student_edit_form');
Route::put('/student_update/{id}',[StudentController::class,'student_update']);
Route::get('read_notification/{id}',[StudentController::class,'read_notification'])->name('read_notification');
Route::get('student_show_announcements',[StudentController::class,'student_show_announcements'])->name('student_show_announcements');
Route::get('upload_admission_fees_receipt/{id}',[StudentController::class,'upload_admission_fees_receipt'])->name('upload_admission_fees_receipt');
Route::post('submit_admission_fees_ss/{id}',[StudentController::class,'submit_admission_fees_ss'])->name('submit_admission_fees_ss');
Route::put('edit_admission_fees_ss/{id}',[StudentController::class,'edit_admission_fees_ss'])->name('edit_admission_fees_ss');
Route::get('upload_monthly_fees/{id}',[StudentController::class,'upload_monthly_fees'])->name('upload_monthly_fees');
Route::post('submit_monthly_fees_ss/{id}',[StudentController::class,'submit_monthly_fees_ss'])->name('submit_monthly_fees_ss');
Route::Put('edit_monthly_fees/{id}',[StudentController::class,'edit_monthly_fees'])->name('edit_monthly_fees');
Route::get('student_fees_status/{id}',[StudentController::class,'student_fees_status'])->name('student_fees_status');
});

Route::get('/student-login',function(){
    return view('student.loginform');
})->middleware(['logged_in_student','guest'])->name('student_login');

Route::post('/student/login',[StudentController::class,'login'])->name('student_login_logic');



Route::post('login',[UserController::class,'login']);



Route::get('changepass',[UserController::class,'changepass']);

Route::get('/register',[StudentController::class,'register'])->name('register');
Route::Post('/student_register',[StudentController::class,'student_register'])->name('student_register');


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


//for atudents
Route::get('student/forgot-password', function () {
    return view('student.forget-password');
})->middleware('guest')->name('student.password.request');

Route::post('student/forget-password',[StudentController::class,'forget_password'])->name('student.entered_email')->middleware('guest');
Route::get('/student_pass_reset/{token}/{email}',[StudentController::class,'showResetForm'])->name('reset.password.form')->middleware('guest');
Route::post('/student-resetpass',[StudentController::class,'student_resetpass'])->name('student.resetpass')->middleware('guest');



//Route::get('relation',[StudentController::class,'relation']);
