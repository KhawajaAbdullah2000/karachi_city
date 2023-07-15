<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branches;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;

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
                return redirect()->route('emp_home',['id'=>auth()->user()->id]);
            }
      
        } else {
            return redirect()->route('login_form')->with('error','Invalid credentials');
        
    }

    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home')->with('success','Logged out successfully');
    
    }
    public function showEmployees(){
        $users = User::latest()->paginate(6);
        return view('admin.DisplayEmployees',['users'=>$users]);
    }

    public function destroy($id){
        $user = User::where('id',$id)->first();
        $user->delete();
        return back();
    }

    public function addEmployee(){
        $branches=Branches::all();
        return view('admin.addEmployee',['branches'=>$branches]);
    }
    public function editEmployee($id){
        $user = User::where('id',$id)->first();
        $branches=Branches::all();
        return view('admin.edit',['user'=>$user,'branches'=>$branches]);
    }
    
    public function updateEmployee(Request $request,$id){
        $request->validate([
            'password' => ['required'],
            'email' => ['required',Rule::unique('users')->ignore($id,'id')],
            'cnic' => ['min:13','max:13','required',Rule::unique('users')->ignore($id,'id')],
            'number' => ['min:11','max:11','required',Rule::unique('users','phone')->ignore($id,'id')],
            'salary' => ['required']
               ]);
        $user = User::where('id',$id)->first();
        if(isset($request->front)){
            $cnicFront = time().'.'.$request->front->extension();
            $request->front->move(public_path('cnic'),$cnicFront);
            $user->cnicFront=$cnicFront;
        }
        if(isset($request->back)){
            $cnicBack = time().'.'.$request->back->extension();
            $request->back->move(public_path('cnic'),$cnicBack);
            $user->cnicBack=$cnicBack;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->number;
        $user->cnic = $request->cnic;
        $user->password=Hash::make($request->password);
        $user->branch_id=$request->branch_id;
        $user->salary=$request->salary;
        $user->save();
        return redirect()->route('admin_home')->withSuccess('Employee Details Updated Scuccessfully');

    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'number' => 'required|numeric|digits:11|unique:users,phone',
            'password' => 'required',
            'cnic' => 'required|numeric|digits:13|unique:users,cnic',
            'number' => 'min:11|max:11|required|unique:users,phone',
            'password' => 'required',
            'cnic' => 'max:13|min:13|required|unique:users,cnic',
            'front' => 'mimes:jpeg,jpg,png|max:10000',
            'back' => 'mimes:jpeg,jpg,png|max:10000',
            'salary' => 'required|numeric',
            'branch_id' => 'required'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->number;
        $user->cnic = $request->cnic;
        $user->password=Hash::make($request->password);

        if(isset($request->front)){
         $cnicFront = time().'.'.$request->front->extension();
         $user->cnicFront=$cnicFront;
         $request->front->move(public_path('cnic'),$cnicFront);
        }
        
        if(isset($request->back)){
            $cnicBack = time().'.'.$request->back->extension();
            $user->cnicBack=$cnicBack;   
             $request->back->move(public_path('cnic'),$cnicBack);
           }
        $user->branch_id=$request->branch_id;

        $user->salary=$request->salary;

        $user->save();

        try{
            $data=['name'=>$user->name];
        Mail::send('emp.newemployee',$data,function($messages) use ($user){
           $messages->to($user->email);
           $messages->subject('Welcome our new Employee');
        });

        }catch(Exception $e){

            return redirect()->route('admin_home')->withSuccess('New Employee Added Successfully but email not sent');
        }


        return redirect()->route('admin_home')->withSuccess('New Employee Added Successfully');
    }
    public function viewEmployee($id){
        $user = User::join('branches','branches.id','=','users.branch_id')->where('users.id',$id)->first();
        return view('admin.viewEmployee',['user'=>$user]);
    }



      public function changepass(){
     $super=User::where('id',1)->first();
         $super->password=Hash::make('12345');
        $super->save();
         dd('done');
     }
     public function displayEmployee($id){
        $user = User::join('branches','branches.id','=','users.branch_id')->where('users.id',$id)->first();
        return view('emp.emp_home',['user'=>$user]);
     }

     public function editEmp($id){
        $user = User::where('id',$id)->first();
        return view('emp.emp_edit',['user'=>$user]);
     }
     public function updateEmp($id,Request $request){
        $request->validate([
            'password' => ['required'],
            'email' => ['required',Rule::unique('users')->ignore($id,'id')],
            'cnic' => ['min:13','max:13','required',Rule::unique('users')->ignore($id,'id')],
            'number' => ['min:11','max:11','required',Rule::unique('users','phone')->ignore($id,'id')]
               ]);
        $user = User::where('id',$id)->first();
        if(isset($request->front)){
            $cnicFront = time().'.'.$request->front->extension();
            $request->front->move(public_path('cnic'),$cnicFront);
            $user->cnicFront=$cnicFront;
        }
        if(isset($request->back)){
            $cnicBack = time().'.'.$request->back->extension();
            $request->back->move(public_path('cnic'),$cnicBack);
            $user->cnicBack=$cnicBack;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->number;
        $user->cnic = $request->cnic;
        $user->password=Hash::make($request->password);
        $user->save();
        return redirect()->route('emp_home',['id'=>$user->id]);
     }

     public function branchDetail($id){
        $user = User::join('branches','branches.id','=','users.branch_id')->where('users.id',$id)->first();
        $count = User::where('branch_id',$user->branch_id)->groupBy('branch_id')->count();
        return view('emp.branchDetails',['user'=>$user,'EmployeeCount'=>$count]);
     }

         public function registered_students(){
                $students= Student::where('admission',0)->get();
                return view('admin.registered_students',['students'=>$students]);
     }

     public function enrolled_students(){
        $students= Student::where('admission',1)->get();
        return view('admin.enrolled_students',['students'=>$students]);
     }

     public function student_admission_fees_paid($id){
        $student=Student::find($id);
        $student->admission=1;
        $student->save();
        return redirect()->route('enrolled_students')->with('success','Student Enrolled Successfully');
     }
}

