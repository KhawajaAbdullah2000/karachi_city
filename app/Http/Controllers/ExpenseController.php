<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\expense;
use App\Models\Branches;
use App\Models\User;

class ExpenseController extends Controller
{
    public function Show($id){
       $expenses= expense::where('branch_id',$id)->get();
       $count= expense::where('branch_id',$id)->count();
       $salary = User::where('branch_id',$id)->sum('salary');
       return view('expenses.expenses_home',['expenses'=>$expenses,'count'=>$count,'salary'=> $salary]);

    }

    public function expenseAdd($id){
        return view('expenses.expenses_add');
    }

    public function store(Request $request,$id){
        $request->validate([
            'Category' => 'required',
            'Amount' => 'required'
        ]);
        
    // Retrieve the expense data from the request
    $expenseData = $request->all();

    // Check for duplicate records
    $duplicateExpense = expense::where('Amount', $expenseData['Amount'])->where('Category', $expenseData['Category'])->first();

    // If a duplicate record is found
    if ($duplicateExpense) {
        return response()->json([
            'duplicate' => true,
            'message' => 'This expense already exists. Are you sure you want to add it again?'
        ]);
    }

    // If no duplicate record is found, proceed with saving the expen

        $expenses = new expense;
        $expenses->Category=$request->Category;
        $expenses->Amount=$request->Amount;
        $expenses->branch_id=$id;
        $expenses->save();
        return redirect()->route('expenses_display',['id'=>$id])->with('status','Expense added successfully!');

    }
}
