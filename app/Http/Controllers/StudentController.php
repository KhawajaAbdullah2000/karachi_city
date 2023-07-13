<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


}
