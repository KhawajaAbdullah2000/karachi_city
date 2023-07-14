<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Branches;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

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

    public function forget_password(Request $req){
        $req->validate([
            'email'=>'required|email|exists:students,email'
        ]);
        $token=Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email'=>$req->email,
            'token'=>$token,
            'created_at'=>Carbon::now(),
        ]);
        $action_link=url('student_pass_reset',['token'=>$token,'email'=>$req->email]);
        $body='You can set your password from this link';
        Mail::send('student.email-forgot',['action_link'=>$action_link,'body'=>$body],function($message) use($req){
                 $message->to($req->email);
                 $message->subject('Pasword reset');

        });
        return back()->with('success','Email sent');

    }

    public function showResetForm($token,$email){
        return view('student.reset-password')->with(['token'=>$token,'email'=>$email]);
    }

    public function student_resetpass(Request $req){
        $req->validate([
            'token' => 'required',
            'email' => 'required|email|exists:students,email',
            'password' => 'required|min:5|confirmed',
        ]);
        $check_token=DB::table('password_reset_tokens')->where([
            'email'=>$req->email,
            'token'=>$req->token
        ])->first();
        if(!$check_token){
            return back()->withInput()->with('error','Invalid details');
        }
        else{
            Student::where('email',$req->email)->update( [
                'password'=>Hash::make($req->password)
                ]);
                Db::table('password_reset_tokens')->where([
                    'email'=>$req->email
                ])->delete();
                return redirect()->route('student_login');
        }


    
    }


}
