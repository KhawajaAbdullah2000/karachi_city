<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\expense;
use App\Models\Branches;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function Show($id){
       $expenses= expense::where('branch_id',$id)->orderby('created_at','desc')->paginate(5);
       $count= expense::where('branch_id',$id)->count();
       
       return view('expenses.expenses_home',['expenses'=>$expenses,'count'=>$count]);

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
        $expenses = new expense;
        $expenses->Category=$request->Category;
        $expenses->Amount=$request->Amount;
        $expenses->branch_id=$id;
        $expenses->save();
        return redirect()->route('expenses_add',['id'=>$id])->with('status','Duplicate record is added. Please, Reconcile; Delete the record if mistakenly added.');
    }


        $expenses = new expense;
        $expenses->Category=$request->Category;
        $expenses->Amount=$request->Amount;
        $expenses->branch_id=$id;
        $expenses->month= Carbon::parse($expenses->created_at)->format('F');
        $expenses->year= Carbon::parse($expenses->created_at)->format('Y');
        $expenses->save();
        return redirect()->route('expenses_display',['id'=>$id])->with('status','Expense added successfully!');

    }
    
    public function edit($id,$branch_id){
        $expenses=expense::where('id',$id)->first();
        
        return view('expenses.expenses_edit',['expenses' => $expenses]);

    }

    public function update(Request $request,$id,$branch_id){
        $expenses = new expense;
        $expenses->Category=$request->Category;
        $expenses->Amount=$request->Amount;
        $expenses->branch_id = $branch_id;
        $expenses->save();
        return redirect()->route('expenses_edit',['id'=>$id,'branch_id' => $branch_id])->with('status','Expense updated successfully!');

    }
    public function destroy(request $request){
        $expensedel = expense::where('id',$request->category_delete_id)->first();
        $expensedel->delete();
        return back();
    }

    public function MonthlyShow($id){
     $monthlyTotals = Expense::select(['year', 'month', DB::raw('SUM(Amount) as total_amount')])->where('branch_id', $id)->groupBy('year', 'month')->orderBy('year', 'asc')->orderBy('month', 'asc')->paginate(12);
     return view('expenses.expenses_home_monthly',['monthlyTotals' => $monthlyTotals]);
    }
}
