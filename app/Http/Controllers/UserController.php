<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branches;
use App\Models\Student;
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

    public function logout(){
        Auth::logout();
        return redirect()->route('home')->with('success','Logged out successfully');
    
    }
    public function showEmployees(){
        $users = User::all();
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
            'password' => 'required'
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
            'email' => 'required',
            'number' => 'required|numeric',
            'password' => 'required',
            'cnic' => 'required|numeric',
            'front' => 'mimes:jpeg,jpg,png|max:10000',
            'back' => 'mimes:jpeg,jpg,png|max:10000',
            'salary' => 'required|numeric',
            'branch_id' => 'required'
        ]);
        $user = new User;
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

        return redirect()->route('admin_home')->withSuccess('New Employee Added Successfully');
    }
    public function viewEmployee($id){
        $user = User::join('branches','branches.id','=','users.branch_id')->where('users.id',$id)->first();
        return view('admin.viewEmployee',['user'=>$user]);
    }



    //  public function changepass(){
    // $super=Student::where('id',1)->first();
    //     $super->password=Hash::make('12345');
    //    $super->save();
    //     dd('done');
    // }
}

