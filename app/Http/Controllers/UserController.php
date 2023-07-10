<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function login(Request $req){
        $req->validate([
            'phone'=>'required|min:11|max:11',
            'password'=>'required'
        ]);

        if (Auth::attempt(['phone' => $req->phone, 'password' => $req->password])) {
            if(auth()->user()->role==1){
                return redirect()->route('admin_home');
            }else{
                return redirect()->route('emp_home');
            }
      
        } else {
            return redirect()->route('login_form')->with('error','Invalid credentials');
        
    }

    }

    public function changepass(){
        $super=User::where('id',2)->first();
        $super->password=Hash::make('12345');
        $super->save();
      }
}

