<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Branches;
use App\Models\Student;
use App\Models\Announcement;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

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

    public function student_edit_form($id){
        $student=Student::find($id);
        return view('student.edit_form',['student'=>$student]);
    }

    public function student_update(Request $req, $id){
        $req->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'DOB'=>'required',
            'phone'=>['required',Rule::unique('students')->ignore($id,'id')],
            'gender'=>'required',
            'school'=>'required',
            'medical'=>'required|max:50',
            'parent_email'=>'required|max:40',
            'parent_phone'=>'required|max:11',
            'emergency_name'=>'required',
            'emergency_contact'=>'required|numeric|digits:11'
        ]);

    
        $student=Student::find($id);
        $student->first_name=$req->first_name;
        $student->last_name=$req->last_name;
        $student->DOB=$req->DOB;
        $student->phone=$req->phone;
        $student->gender=$req->gender;
        $student->school=$req->school;
        $student->medical=$req->medical;
        $student->parent_email=$req->parent_email;
        $student->parent_phone=$req->parent_phone;
        $student->emergency_name=$req->emergency_name;
        $student->emergency_contact=$req->emergency_contact;
        $student->save();
        return redirect()->route('student_home')->with('updated','Your details are updated!');

    }

    public function read_notification($id){
        if($id){
            auth('student')->user()->notifications->where('id',$id)->markAsRead();
        }
        return back();

    }

    public function student_show_announcements(){
          $announcements=Announcement::orderby('created_at','desc')->get();
          ($announcements);
          return view('student.announcements',['announcements'=>$announcements]);
    }

    public function upload_admission_fees_receipt($id){
        $student=Student::find($id);
        return view('student.upload_admission_fees',['student'=>$student]);
    }

    public function submit_admission_fees_ss(Request $req,$id){
        $req->validate([
            'admission_fees_ss'=>'required|mimes:jpeg,jpg,png|max:20000'
        ]);
        $student=Student::find($id);

        $imagename=time().'.'.$req->admission_fees_ss->extension();
        $req->admission_fees_ss->move(public_path('admission_fees'),$imagename);

        $student->admission_fees_ss=$imagename;
        $student->save();
      return redirect()->route('student_home')->with('updated','Admission fees receipt uploaded');
       
    }
    public function edit_admission_fees_ss(Request $req,$id){
        $req->validate([
            'admission_fees_ss'=>'required|mimes:jpeg,jpg,png|max:20000'
        ]);
        $student=Student::find($id);
        //deleting previous image from public folder
        unlink(public_path('/admission_fees'.'/'.$student->admission_fees_ss) );
//adding the new image
        $imagename=time().'.'.$req->admission_fees_ss->extension();
        $req->admission_fees_ss->move(public_path('admission_fees'),$imagename);

        $student->admission_fees_ss=$imagename;
        $student->save();

        return redirect()->route('upload_admission_fees_receipt',['id'=>$student->id])->with('updated','new Image uploaded successfully');

        

    }



}
