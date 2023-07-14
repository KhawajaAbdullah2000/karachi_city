<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\leaves;

class LeavesController extends Controller
{
    public function myLeaves($id){
        $leaves = leaves::where('emp_id',$id)->get();
        return view('emp.myLeaves',['leaves'=>$leaves]);
    }
    public function leaveForm($id){
        return view('emp.leaveForm');
    }
    public function leavestore($id,Request $request){
        $request->validate([
            'reason' => 'required',
            'details' => 'required',
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $leave = new leaves;
        $leave->emp_id = $id;
        $leave->reason = $request->reason;
        $leave->details = $request->details;
        $leave->from_date = $request->from_date;
        $leave->to_date = $request->to_date;
        $leave->save();
        return redirect()->route('emp_myLeaves',['id'=>$id]);
    }

    public function showLeaves($id){
        $leaves = leaves::where('emp_id',$id)->get();
        return view('admin.showLeaves',['leaves'=>$leaves]);

    }
    public function approveLeave($l_id){
        $leave = leaves::where('id',$l_id)->first();
        $leave->status = 1;
        $leave->save();
        return redirect()->route('showEmployees');
    }
}
