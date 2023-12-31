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
use Spatie\Permission\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function login(Request $req)
    {
        $req->validate([
            'phone' => 'required|min:11|max:11',
            'password' => 'required'
        ]);

        if (Auth::attempt(['phone' => $req->phone, 'password' => $req->password])) {
            if (auth()->user()->role == 1) {
                return redirect()->route('admin_home');
            } else {
                return redirect()->route('emp_home', ['id' => auth()->user()->id]);
            }
        } else {
            return redirect()->route('login_form')->with('error', 'Invalid credentials');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Logged out successfully');
    }
    public function showEmployees()
    {
        $users = User::latest()->paginate(6);
        return view('admin.DisplayEmployees', ['users' => $users]);
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();
        return back();
    }

    public function addEmployee()
    {
        $branches = Branches::all();
        return view('admin.addEmployee', ['branches' => $branches]);
    }
    public function editEmployee($id)
    {
        $user = User::where('id', $id)->first();
        $branches = Branches::all();
        return view('admin.edit', ['user' => $user, 'branches' => $branches]);
    }

    public function updateEmployee(Request $request, $id)
    {
        $request->validate([
            'password' => ['required'],
            'email' => ['required', Rule::unique('users')->ignore($id, 'id')],
            'cnic' => ['min:13', 'max:13', 'required', Rule::unique('users')->ignore($id, 'id')],
            'number' => ['min:11', 'max:11', 'required', Rule::unique('users', 'phone')->ignore($id, 'id')],
            'salary' => ['required'],
            'branch_id' => ['required']
        ]);
        $user = User::where('id', $id)->first();
        if (isset($request->front)) {
            $cnicFront = time() . '.' . $request->front->extension();
            $request->front->move(public_path('cnic'), $cnicFront);
            $user->cnicFront = $cnicFront;
        }
        if (isset($request->back)) {
            $cnicBack = time() . '.' . $request->back->extension();
            $request->back->move(public_path('cnic'), $cnicBack);
            $user->cnicBack = $cnicBack;
        }
        if ($user->branch_id != $request->branch_id && $user->hasRole('manager')) {
            $user->removeRole('manager');
            $branch = Branches::where('id', $user->branch_id)->first();
            $branch->manager_id = null;
            $branch->save();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->number;
        $user->cnic = $request->cnic;
        $user->password = Hash::make($request->password);
        $user->branch_id = $request->branch_id;
        $user->salary = $request->salary;
        $user->save();
        return redirect()->route('admin_home')->withSuccess('Employee Details Updated Successfully');
    }

    public function store(Request $request)
    {
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
        $user->password = Hash::make($request->password);

        if (isset($request->front)) {
            $cnicFront = time() . '.' . $request->front->extension();
            $user->cnicFront = $cnicFront;
            $request->front->move(public_path('cnic'), $cnicFront);
        }

        if (isset($request->back)) {
            $cnicBack = time() . '.' . $request->back->extension();
            $user->cnicBack = $cnicBack;
            $request->back->move(public_path('cnic'), $cnicBack);
        }
        $user->branch_id = $request->branch_id;

        $user->salary = $request->salary;

        $user->save();

        try {
            $data = ['name' => $user->name];
            Mail::send('emp.newemployee', $data, function ($messages) use ($user) {
                $messages->to($user->email);
                $messages->subject('Welcome our new Employee');
            });
        } catch (Exception $e) {

            return redirect()->route('admin_home')->withSuccess('New Employee Added Successfully but email not sent');
        }


        return redirect()->route('admin_home')->withSuccess('New Employee Added Successfully');
    }
    public function viewEmployee($id)
    {
        $user = User::leftjoin('branches', 'branches.id', '=', 'users.branch_id')->where('users.id', $id)->first();
        return view('admin.viewEmployee', ['user' => $user]);
    }



    public function changepass()
    {
        $super = User::where('id', 1)->first();
        $super->password = Hash::make('12345');
        $super->save();
        dd('done');
    }
    public function displayEmployee($id)
    {
        $user = User::leftjoin('branches', 'branches.id', '=', 'users.branch_id')->where('users.id', $id)->first();
        return view('emp.emp_home', ['user' => $user]);
    }

    public function editEmp($id)
    {
        $user = User::where('id', $id)->first();
        return view('emp.emp_edit', ['user' => $user]);
    }
    public function updateEmp($id, Request $request)
    {
        $request->validate([
            'password' => ['required'],
            'email' => ['required', Rule::unique('users')->ignore($id, 'id')],
            'cnic' => ['min:13', 'max:13', 'required', Rule::unique('users')->ignore($id, 'id')],
            'number' => ['min:11', 'max:11', 'required', Rule::unique('users', 'phone')->ignore($id, 'id')]
        ]);
        $user = User::where('id', $id)->first();
        if (isset($request->front)) {
            $cnicFront = time() . '.' . $request->front->extension();
            $request->front->move(public_path('cnic'), $cnicFront);
            $user->cnicFront = $cnicFront;
        }
        if (isset($request->back)) {
            $cnicBack = time() . '.' . $request->back->extension();
            $request->back->move(public_path('cnic'), $cnicBack);
            $user->cnicBack = $cnicBack;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->number;
        $user->cnic = $request->cnic;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('emp_home', ['id' => $user->id]);
    }

    public function branchDetail($id)
    {
        $user = User::join('branches', 'branches.id', '=', 'users.branch_id')->where('users.id', $id)->first();
        $count = User::where('branch_id', $user->branch_id)->groupBy('branch_id')->count();
        return view('emp.branchDetails', ['user' => $user, 'EmployeeCount' => $count]);
    }

    public function registered_students($branch_id)
    {
        $students = Student::where('admission', 0)->where('branch_id', $branch_id)->get();
        return view('admin.registered_students', ['students' => $students]);
    }

    public function enrolled_students($branch_id)
    {
        $students = Student::where('admission', 1)->where('branch_id', $branch_id)->get();
        return view('admin.enrolled_students', ['students' => $students]);
    }



    public function make_announcement()
    {
        return view('admin.make_announcement');
    }

    public function create_announcement(Request $req)
    {
        $req->validate([
            'title' => 'required|max:30',
            'description' => 'required|max:70'
        ]);
        $ann = new Announcement();
        $ann->title = $req->title;
        $ann->description = $req->description;
        $ann->save();
        $students = Student::where('admission', 1)->get();
        foreach ($students as $stud) {
            $stud->notify(new AnnouncementNotification($ann));
        }


        return redirect()->route('announcements')->with('success', 'Announcement created');
    }

    public function announcements()
    {
        $announcements = Announcement::orderby('created_at', 'desc')->paginate(5);
        return view('admin.announcements', ['announcements' => $announcements]);
    }
    public function edit_announcement($id)
    {
        $ann = Announcement::find($id);
        return view('admin.edit_announcement', ['announcement' => $ann]);
    }
    public function submit_edit_announcement(Request $req, $id)
    {
        $req->validate([
            'title' => 'required|max:30',
            'description' => 'required|max:70'
        ]);
        $ann = Announcement::find($id);
        $ann->title = $req->title;
        $ann->description = $req->description;
        $ann->save();
        return redirect()->route('announcements')->with('success', 'Edited announcement successfully');
    }
    public function destroy_announcement($id)
    {
        $ann = Announcement::where('id', $id)->first();
        $ann->delete();
        return back()->withSuccess('Product deleted');
    }

    public function check_monthly_fees_current($branch_id)
    {
        $current = Carbon::now();
        $month = $current->format('F');
        $year = $current->format('Y');
        $students = Student::select(
            'students.id as studentid',
            'students.first_name',
            'students.last_name',
            'students.branch_id',
            'monthly_fees.month',
            'monthly_fees.year',
            'monthly_fees.monthly_fees_ss',
            'monthly_fees.paid',
            'students.admission'
        )
            ->join('monthly_fees', 'monthly_fees.student_id', '=', 'students.id')
            ->where('students.branch_id', $branch_id)->where('month', $month)->where('year', $year)
            ->orderby('monthly_fees.updated_at', 'desc')
            ->get();
        $totalstudents = Student::where('branch_id', $branch_id)->where('admission', 1)->count();
        $paid = MonthlyFee::join('students', 'students.id', '=', 'monthly_fees.student_id')
            ->where('students.branch_id', $branch_id)->where('month', $month)->where('year', $year)
            ->where('paid', 1)->count();

        return view(
            'emp.check_monthly_fees_current',
            [
                'students' => $students, 'month' => $month, 'year' => $year,
                'totalstudents' => $totalstudents, 'paid' => $paid
            ]
        );
    }



    public function paid_monthly_fees($id, $branch_id)
    {
        //online payment
        $current = Carbon::now();
        $month = $current->format('F');
        $year = $current->format('Y');
        $stu = MonthlyFee::where('student_id', $id)->where('month', $month)->where('year', $year)
            ->where('paid', 0)->first();
        if ($stu) {
            $stu->paid = 1;
            $stu->save();
            Db::table('monthlyfees_revenues')->insert(
                [
                    'student_id' => $stu->id,
                    'branch_id' => $branch_id,
                    'fees_for' => Carbon::now()->format('Y-m-d'),
                    'amount' => 7000
                ]
            );

            return redirect()->route('check_monthly_fees_current', ['branch_id' => $branch_id])->with('success', 'Record updated');
        }
    }

    public function add_new_cash_payment($branch_id)
    {
        $current = Carbon::now();
        $month = $current->format('F');
        $year = $current->format('Y');
        $students = Student::where('branch_id', $branch_id)->where('admission', 1)->get();
        return view('emp.monthly_cash_payment', ['students' => $students, 'month' => $month, 'year' => $year]);
    }

    public function add_cash_record_monthly(Request $req)
    {
        $req->validate(
            [
                'student_id' => 'required'
            ],
            [
                'student_id.required' => 'please select a student'

            ]
        );
        $current = Carbon::now();
        $month = $current->format('F');
        $year = $current->format('Y');

        $check = MonthlyFee::where('student_id', $req->student_id)->where('month', $month)->where('year', $year);

        if ($check->count() == 0) {

            $new = new MonthlyFee();
            $new->student_id = $req->student_id;
            $new->fees_for = Carbon::now()->format('Y-m-d');
            $new->paid = 1;
            $new->month = $month;
            $new->year = $year;
            $new->save();
            Db::table('monthlyfees_revenues')->insert(
                [
                    'student_id' => $req->student_id,
                    'branch_id' => auth()->user()->branch_id,
                    'fees_for' => Carbon::now()->format('Y-m-d'),
                    'amount' => 7000
                ]
            );
        } else {
            return redirect()->route('check_monthly_fees_current', ['branch_id' => auth()->user()->branch_id])
                ->with('error', 'Record already exists.please check again if the student had uploaded screenshot for the current month');
        }


        return redirect()->route('check_monthly_fees_current', ['branch_id' => auth()->user()->branch_id])->with('success', 'Record added');
    }



    public function monthly_fees_record($branch_id, Request $req)
    {
        $current = Carbon::now();
        $year = $current->format('Y');
        $students = Student::query();
        $students->select(
            'students.id',
            'students.first_name',
            'students.last_name',
            'students.branch_id',
            'monthly_fees.month',
            'monthly_fees.year',
            'monthly_fees.monthly_fees_ss',
            'monthly_fees.paid',
            'students.admission'
        )

            ->join('monthly_fees', 'monthly_fees.student_id', '=', 'students.id')

            ->where('students.branch_id', $branch_id)->where('students.admission', 1);

        if ($req->has('month') && $req->has('year') && !empty($req->input('month')) && !empty($req->input('year'))) {
            $students->where('monthly_fees.month', 'like', '%' . $req->input('month') . '%')
                ->where('monthly_fees.year', $req->input('year'));;
        }

        return view('emp.monthly_fees_record', ['students' => $students->orderby('monthly_fees.updated_at', 'desc')->paginate(8)->withQueryString(), 'cur_year' => $year]);
    }

    public function delete_student($id)
    {
        $student = Student::where('id', $id)->first();
        if ($student) {
            $student->delete();
            return redirect()->back()->with('success', 'Student deleted');
        } else {
            return redirect()->back()->with('error', 'Student not found');
        }
    }


    //CHeck allregistered students for Admin
    public function all_registered_students()
    {
        $students = Student::where('admission', 0)->get();
        return view('student.all_registered_students', ['students' => $students]);
    }

    //invice form for admission
    public function student_admission_invoice($id)
    {
        $student = Student::join('branches', 'students.branch_id', 'branches.id')->where('students.id', $id)->where('admission', 0)
            ->first(['students.first_name', 'students.last_name', 'students.id', 'branches.branch_name']);
        return view('student.register_invoice_form', ['student' => $student]);
    }

    public function send_registeration_invoice(Request $req, $id)
    {

        $req->validate([
            'reg_fees' => 'required',
            'month1' => 'required',
            'month1_fees' => 'required'
        ]);
        $student = Student::join('branches', 'students.branch_id', 'branches.id')->where('students.id', $id)->where('admission', 0)
            ->first(['students.first_name', 'students.last_name', 'students.id', 'branches.branch_name', 'students.email']);

        if ($req->month2_fees == null) {
            $total_amount = $req->reg_fees + $req->month1_fees;
        } else {
            $total_amount = $req->reg_fees + $req->month1_fees + $req->month2_fees;
        }


        $pdf = PDF::loadView(
            'pdf.registeration_template',
            [
                'f_name' => $student->first_name,
                'l_name' => $student->last_name,
                'branch_name' => $student->branch_name,
                'total_amount' => $total_amount,
                'reg_fees' => $req->reg_fees,
                'month1' => $req->month1,
                'month2' => $req->month2,
                'month1_fees' => $req->month1_fees,
                'month2_fees' => $req->month2_fees,

            ]
        );

        $pdfContent = $pdf->output();

        try {
            $data = [
                'first_name' => $student->first_name,
                'last_name' => $student->last_name

            ];
            Mail::send('email.registeration_invoice', $data, function ($messages) use ($student, $pdfContent) {
                $messages->to($student->email)
                    ->subject('Karachi City Registeration')
                    ->attachData($pdfContent, 'invoice.pdf', ['mime' => 'application/pdf']);
            });
            return redirect()->route('all_registered_students');
        } catch (Exception $e) {

            return redirect()->route('admin_home')->withError('Couldnt send the email.');
        }
    }

    //form view
    public function student_admission_fees_paid($id)
    {

        $student = Student::join('branches', 'students.branch_id', 'branches.id')->where('students.id', $id)->where('admission', 0)
            ->first(['students.first_name', 'students.last_name', 'students.id', 'branches.branch_name']);
        return view('student.confirmAdmissionPayment', ['student' => $student]);
    }

    public function add_registeration_fees(Request $req, $id)
    {

        $req->validate([
            'reg_fees' => 'required',
            'month1' => 'required',
            'month1_fees' => 'required'
        ]);

        $student = Db::table('students')->where('id',$id)->first();

        Db::table('admissionfees_revenues')->insert([
            'student_id' => $id,
            'fees_for' => Carbon::now()->format('Y-m-d'),
            'branch_id' => $student->branch_id,
            'amount' => $req->reg_fees
        ]);

        Db::table('students')->where('id',$id)->update([
            'admission'=>1
        ]);


        //monthfee
        DB::table('monthlyfees_revenues')->insert([
             'student_id'=>$id,
             'month'=>$req->month1,
             'year'=>Carbon::now()->format('Y'),
             'branch_id'=>$student->branch_id,
             'amount'=>$req->month1_fees
        ]);

        if($req->month2!=null && $req->month2_fees!=null){
            DB::table('monthlyfees_revenues')->insert([
                'student_id'=>$id,
                'month'=>$req->month2,
                'year'=>Carbon::now()->format('Y'),
                'branch_id'=>$student->branch_id,
                'amount'=>$req->month2_fees
           ]);

        }



        return redirect()->route('all_registered_students');
    }

    public function all_enrolled_students()
    {

        $students = Student::where('admission', 1)->get();
        return view('student.all_enrolled_students', ['students' => $students]);
    }

    public function student_monthly_invoice($id)
    {
        $student = Student::join('branches', 'students.branch_id', 'branches.id')->where('students.id', $id)->where('admission', 1)
            ->first(['students.first_name', 'students.last_name', 'students.id', 'branches.branch_name']);
        return view('student.monthly_invoice_form', ['student' => $student]);
    }

    public function send_monthly_invoice(Request $req, $id)
    {
        $req->validate([
            'month' => 'required',
            'month_fees' => 'required',
            'due_date'=>'required',
            'grace_period'=>'required'
        ]);

        $dueDate = $req->input('due_date');
        $carbonDueDate = Carbon::parse($dueDate);
        $formattedDueDate = $carbonDueDate->format('F jS, Y');

        $graceDate = $req->input('grace_period');
        $carbonGraceDate = Carbon::parse($graceDate);
        $formattedGraceDate = $carbonGraceDate->format('F jS, Y');

        $student = Student::join('branches', 'students.branch_id', 'branches.id')->where('students.id', $id)->where('admission', 1)
            ->first(['students.id', 'students.first_name', 'students.last_name', 'students.id', 'branches.branch_name', 'students.email']);


        $year = Carbon::now()->format('Y');


        $pdf = PDF::loadView(
            'pdf.monthly_fee_template',
            [
                'id' => $id,
                'f_name' => $student->first_name,
                'l_name' => $student->last_name,
                'branch_name' => $student->branch_name,
                'fees' => $req->month_fees,
                'month' => $req->month,
                'year' => $year,
                'due_date'=>$formattedDueDate,
                'grace_period'=>$formattedGraceDate

            ]
        );

        $pdfContent = $pdf->output();

        try {
            $data = [
                'first_name' => $student->first_name,
                'last_name' => $student->last_name

            ];
            Mail::send('email.monthly_fee_invoice', $data, function ($messages) use ($student, $pdfContent) {
                $messages->to($student->email)
                    ->subject('Karachi City FC')
                    ->attachData($pdfContent, 'MonthlyFees.pdf', ['mime' => 'application/pdf']);
            });
            return redirect()->route('all_enrolled_students')->with('success','Monthly Invoice sent');
        } catch (Exception $e) {

            return redirect()->route('admin_home')->withError('Couldnt send the email.');
        }
    }

    public function student_monthly_fees_paid($id){
        $student = Student::join('branches', 'students.branch_id', 'branches.id')->where('students.id', $id)->where('admission', 1)
        ->first(['students.first_name', 'students.last_name', 'students.id', 'branches.branch_name']);
         return view('student.confirmMonthlyPayment', ['student' => $student]);
    }

    public function add_monthly_fees(Request $req,$id){
        $req->validate([
            'month' => 'required',
            'month_fees' => 'required'
        ]);

        $student = Db::table('students')->where('id',$id)->first();

try{
     //monthfee
     DB::table('monthlyfees_revenues')->insert([
        'student_id'=>$id,
        'month'=>$req->month,
        'year'=>Carbon::now()->format('Y'),
        'branch_id'=>$student->branch_id,
        'amount'=>$req->month_fees
   ]);

   return redirect()->route('all_registered_students')->with('success','Payment confirmed');


}catch(Exception $e){
    return redirect()->route('all_registered_students')->with('error','Payment was already confirmed for this month');

}

    }

    public function fees_this_month(){
        $currentMonth=Carbon::now()->format('F');
        $currentYear = now()->format('Y');  // Get the current year

        $studentsWithFees = Student::leftJoin('monthlyfees_revenues', function ($join) use ($currentMonth, $currentYear) {
                $join->on('students.id', '=', 'monthlyfees_revenues.student_id')
                    ->where('monthlyfees_revenues.month', $currentMonth)
                    ->where('monthlyfees_revenues.year', $currentYear);
            })
            ->leftJoin('branches', 'students.branch_id', '=', 'branches.id')
            ->where('students.admission',1)
            ->whereNull('monthlyfees_revenues.student_id')
            ->orWhereNotNull('monthlyfees_revenues.student_id')
         ->select('students.id', 'students.first_name', 'students.last_name','students.email',
         'monthlyfees_revenues.month', 'monthlyfees_revenues.year','branches.branch_name')
            ->get();

            return view('student.admin_check_fees_current_month',[
                'students'=>$studentsWithFees,
                'month'=>$currentMonth,
                'year'=>$currentYear
            ]);


    }
}
