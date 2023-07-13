<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Branches;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;



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
            'password'=>'required|max:20',
            'phone'=>'required|numeric|digits:11',
            'school'=>'required',
            'medical'=>'required|max:50',
            'parent_email'=>'required|max:40',
            'parent_phone'=>'required|max:11',
            'emergency_name'=>'required',
            'emergency_contact'=>'required|max:11',

        ]);
        $user=Student::create(array_merge($req->all(), ['password' => bcrypt($req->password)]));

        return redirect()->route('home')->with('registered','Please check your email inbox');
    



    }


}
