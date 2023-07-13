<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Branches;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class StudentController extends Controller
{
    public function login(Request $req){
      
        $req->validate([
            'email'=>'required|',
            'password'=>'required'
        ]);

        if (Auth::guard('student')->attempt(['email' => $req->email, 'password' => $req->password])) 
        {
              return redirect()->route('student_home');
      
        }
         else {
            return redirect()->route('student_login')->with('error','Invalid credentials');
        
    }

    
    }
    public function student_home(){
        return view('student.student_home');
    }

    public function logout(){
        Auth::guard('student')->logout();
        return redirect()->route('home')->with('success','Logged out successfully');
    
    }
    public function register(){
         $branches=Branches::all();
         return view('student.register_form',['branches'=>$branches]);
    }

    public function student_register(Request $req){
        $req->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'DOB'=>'required',
            'gender'=>'required',
            'email'=>'required|max:40|unique:students',
            'password'=>'required|same:passconfirm|max:20',
            'phone'=>'required|numeric|digits:11|unique:students',
            'school'=>'required',
            'medical'=>'required|max:50',
            'parent_email'=>'required|max:40',
            'branch_id'=>'required',
            'parent_phone'=>'required|max:11',
            'emergency_name'=>'required',
            'emergency_contact'=>'required|max:11',

        ],
        [
            'DOB.required' => 'Date of birth is required',
            'password.same'=>'Password and confrim password must match'
        ]);
            
        $user=Student::create(array_merge($req->all(), ['password' => bcrypt($req->password)])); //user created

        $data=['f_name'=>$user->first_name,'l_name'=>$user->last_name];
        Mail::send('student.admission_invoice',$data,function($messages) use ($user){
           $messages->to($user->email);
           $messages->subject('Welcome to Karachi City');
        });

        return redirect()->route('home')->with('registered','Please check your email inbox');
    



    }


}
