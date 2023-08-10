<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branches;
use App\Models\Student;
use App\Models\Announcement;
use App\Models\MonthlyFee;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Notifications\AnnouncementNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\TabCompletion\Matcher\FunctionsMatcher;
use Spatie\Permission\Models\Role;


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
            'salary' => ['required'],
            'branch_id' => ['required']
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
        if($user->branch_id!=$request->branch_id && $user->hasRole('manager')){
            $user->removeRole('manager');
            $branch = Branches::where('id',$user->branch_id)->first();
            $branch->manager_id= null;
            $branch->save();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->number;
        $user->cnic = $request->cnic;
        $user->password=Hash::make($request->password);
        $user->branch_id=$request->branch_id;
        $user->salary=$request->salary;
        $user->save();
        return redirect()->route('admin_home')->withSuccess('Employee Details Updated Successfully');

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
        $user = User::leftjoin('branches','branches.id','=','users.branch_id')->where('users.id',$id)->first();
        return view('admin.viewEmployee',['user'=>$user]);
    }



      public function changepass(){
     $super=User::where('id',1)->first();
         $super->password=Hash::make('12345');
        $super->save();
         dd('done');
     }
     public function displayEmployee($id){
        $user = User::leftjoin('branches','branches.id','=','users.branch_id')->where('users.id',$id)->first();
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

         public function registered_students($branch_id){
                $students= Student::where('admission',0)->where('branch_id',$branch_id)->get();
                return view('admin.registered_students',['students'=>$students]);
     }

     public function enrolled_students($branch_id){
        $students= Student::where('admission',1)->where('branch_id',$branch_id)->get();
        return view('admin.enrolled_students',['students'=>$students]);
     }

     public function student_admission_fees_paid($id,$branch_id){
        $student=Student::find($id);
        $student->admission=1;
        $student->save();


        Db::table('admissionfees_revenues')->insert(
            [
                'student_id'=>$student->id,
                'branch_id'=>$branch_id,
                'fees_for'=>Carbon::now()->format('Y-m-d'),
                'amount'=>5000
            ]
            );
            $advanced_amount=7000;
            $currentDate = Carbon::now();
            $dayOfMonth = $currentDate->day;
            if($dayOfMonth>15){
                $advanced_amount=3500;
            }

            Db::table('monthlyfees_revenues')->insert(
                [
                    'student_id'=>$student->id,
                    'branch_id'=>$branch_id,
                    'fees_for'=>Carbon::now()->format('Y-m-d'),
                    'amount'=>$advanced_amount
                ]
                );
                $current=Carbon::now();
                $month=$current->format('F');
                $year=$current->format('Y');
        
                $new=new MonthlyFee();
                $new->student_id=$student->id;
                $new->fees_for=Carbon::now()->format('Y-m-d');
                $new->paid=1;
                $new->month=$month;
                $new->year=$year;
                $new->save();
        return redirect()->route('enrolled_students',['branch_id'=>$branch_id])->with('success','Student Enrolled Successfully');
     }




     public function make_announcement(){
        return view('admin.make_announcement');
     }

     public function create_announcement(Request $req){
        $req->validate([
            'title'=>'required|max:30',
            'description'=>'required|max:70'
        ]);
        $ann=new Announcement();
        $ann->title=$req->title;
        $ann->description=$req->description;
        $ann->save();
        $students=Student::where('admission',1)->get();
        foreach($students as $stud){
            $stud->notify(new AnnouncementNotification($ann));
        }

        
        return redirect()->route('announcements')->with('success','Announcement created');

     }

     public function announcements(){
        $announcements=Announcement::orderby('created_at','desc')->paginate(5);
        return view('admin.announcements',['announcements'=>$announcements]);
     }
     public function edit_announcement($id){
        $ann=Announcement::find($id);
        return view('admin.edit_announcement',['announcement'=>$ann]);
     }
     public function submit_edit_announcement(Request $req,$id){
        $req->validate([
            'title'=>'required|max:30',
            'description'=>'required|max:70'
        ]);
        $ann=Announcement::find($id);
        $ann->title=$req->title;
        $ann->description=$req->description;
        $ann->save();
        return redirect()->route('announcements')->with('success','Edited announcement successfully');

     }
     public function destroy_announcement($id){
        $ann=Announcement::where('id',$id)->first();
        $ann->delete();
        return back()->withSuccess('Product deleted');
     }

     public function check_monthly_fees_current($branch_id){
        $current=Carbon::now();
        $month=$current->format('F');
        $year=$current->format('Y');
        $students=Student::select('students.id as studentid','students.first_name','students.last_name',
        'students.branch_id','monthly_fees.month','monthly_fees.year',
        'monthly_fees.monthly_fees_ss','monthly_fees.paid','students.admission')
        ->join('monthly_fees','monthly_fees.student_id','=','students.id')
        ->where('students.branch_id',$branch_id)->where('month',$month)->where('year',$year)
        ->orderby('monthly_fees.updated_at','desc')
        ->get();
        $totalstudents=Student::where('branch_id',$branch_id)->where('admission',1)->count();
        $paid=MonthlyFee::join('students','students.id','=','monthly_fees.student_id')
        ->where('students.branch_id',$branch_id)->where('month',$month)->where('year',$year)
        ->where('paid',1)->count();
       
        return view('emp.check_monthly_fees_current',
        ['students'=>$students,'month'=>$month,'year'=>$year,
        'totalstudents'=>$totalstudents,'paid'=>$paid]
    );
     }

    

     public function paid_monthly_fees($id,$branch_id)
     {
        //online payment
        $current=Carbon::now();
        $month=$current->format('F');
        $year=$current->format('Y');
        $stu=MonthlyFee::where('student_id',$id)->where('month',$month)->where('year',$year)
        ->where('paid',0)->first();
        if($stu){
            $stu->paid=1;
            $stu->save();
            Db::table('monthlyfees_revenues')->insert(
                [
                    'student_id'=>$stu->id,
                    'branch_id'=>$branch_id,
                    'fees_for'=>Carbon::now()->format('Y-m-d'),
                    'amount'=>7000
                ]
                );

            return redirect()->route('check_monthly_fees_current',['branch_id'=>$branch_id])->with('success','Record updated');
        }
       
     }

     public function add_new_cash_payment($branch_id){
        $current=Carbon::now();
        $month=$current->format('F');
        $year=$current->format('Y');
        $students=Student::where('branch_id',$branch_id)->where('admission',1)->get();
        return view('emp.monthly_cash_payment',['students'=>$students,'month'=>$month,'year'=>$year]);
     }

     public function add_cash_record_monthly(Request $req){
         $req->validate([
            'student_id'=>'required'
         ],
         ['student_id.required'=>'please select a student'
        
         ]
        );
        $current=Carbon::now();
        $month=$current->format('F');
        $year=$current->format('Y');
        
    $check=MonthlyFee::where('student_id',$req->student_id)->where('month',$month)->where('year',$year);

    if($check->count()==0){

        $new=new MonthlyFee();
        $new->student_id=$req->student_id;
        $new->fees_for=Carbon::now()->format('Y-m-d');
        $new->paid=1;
        $new->month=$month;
        $new->year=$year;
        $new->save();
        Db::table('monthlyfees_revenues')->insert(
            [
                'student_id'=>$req->student_id,
                'branch_id'=>auth()->user()->branch_id,
                'fees_for'=>Carbon::now()->format('Y-m-d'),
                'amount'=>7000
            ]
            );

    }else{
        return redirect()->route('check_monthly_fees_current',['branch_id'=>auth()->user()->branch_id])
        ->with('error','Record already exists.please check again if the student had uploaded screenshot for the current month');
    }
           
        
       return redirect()->route('check_monthly_fees_current',['branch_id'=>auth()->user()->branch_id])->with('success','Record added');

    
     }



     public function monthly_fees_record($branch_id,Request $req){
        $current=Carbon::now();
        $year=$current->format('Y');
       $students=Student::query();
       $students->select('students.id','students.first_name','students.last_name',
       'students.branch_id','monthly_fees.month','monthly_fees.year',
       'monthly_fees.monthly_fees_ss','monthly_fees.paid','students.admission')
       
       ->join('monthly_fees','monthly_fees.student_id','=','students.id')

       ->where('students.branch_id',$branch_id)->where('students.admission',1);

       if($req->has('month') && $req->has('year') && !empty($req->input('month')) && !empty($req->input('year'))){
        $students->where('monthly_fees.month','like','%'.$req->input('month').'%')
        ->where('monthly_fees.year',$req->input('year'));
        ;
       }
       
       return view('emp.monthly_fees_record',['students'=>$students->orderby('monthly_fees.updated_at','desc')->paginate(8)->withQueryString(),'cur_year'=>$year]);
      

     }

     public function delete_student($id){
        $student=Student::where('id',$id)->first();
        if($student){
            $student->delete();
            return redirect()->back()->with('success','Student deleted');
        }else{
            return redirect()->back()->with('error','Student not found');

        }
     }


    //  public function pay_previous_fees($student_id,$month,$year){
    //     $stu=MonthlyFee::where('student_id',$student_id)->where('month',$month)->where('year',$year)->where('paid',0)->first();
    //     if($stu){
    //         $stu->paid=1;
    //         $stu->save();
    //         return redirect()->route('monthly_fees_record',['id'=>auth()->user()->branch_id]);
    //     }
    //     else{
    //         //if paid by cash now for some previous month
    //         $new=new MonthlyFee();
    //         $new->student_id=$student_id;
    //         $new->fees_for=Carbon::now()->formay('Y-m-d');
    //         $new->paid=1;
    //         $new->month=$month;
    //         $new->year=$year;
    //         $new->save();
    //         return redirect()->route('monthly_fees_record',['id'=>auth()->user()->branch_id]);
    //     }

    //  }
}

