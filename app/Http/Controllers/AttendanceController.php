<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branches;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    //
    public function displayAttendance($id){
        $att = Attendance::join('students','students.id','=','attendances.student_id')->where('attendances.branch_id',$id)->get();

        return view('emp.studentAttendance',['attendance'=>$att]);
    }
}
