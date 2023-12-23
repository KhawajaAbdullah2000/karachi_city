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
       
       
       return view('expenses.expenses_home',['expenses'=>$expenses]);

    }

    public function expenseAdd($id){
        
        return view('expenses.expenses_add');
    }

    public function store(Request $request,$id){
        $request->validate([
            'Category' => 'required',
            'Amount' => 'required'
        ]);
        
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
     $monthlyTotals = Expense::select(['year', 'month', DB::raw('SUM(Amount) as total_amount')])->where('branch_id', $id)->groupBy('year', 'month')->orderBy('year', 'desc')->orderBy('month', 'desc')->paginate(12);
     return view('expenses.expenses_home_monthly',['monthlyTotals' => $monthlyTotals],['branch_id'=> $id]);
    }
    
    public function yearlyShow($id){
     $yearlyTotals = Expense::select(['year',  DB::raw('SUM(Amount) as total_amount')])->where('branch_id', $id)->groupBy('year')->orderBy('year', 'desc')->paginate(12);
     return view('expenses.expenses_home_yearly',['yearlyTotals' => $yearlyTotals]);
    }
    
    public function ShowMonthlyDetails($branch_id,$month){
     $monthDetails = Expense::where('branch_id',$branch_id)->where('month',$month)->paginate(10);
     return view('expenses.expenses_home_details',['monthlydetails' => $monthDetails]);
    }
    public function ShowMonthlyFees($id){
        $monthlyfees = DB::table(DB::raw('(
            SELECT 
                SUM(amount) as total_amount,
                month,
                year
            FROM 
                monthlyfees_revenues
            WHERE 
                branch_id = :branchId
            GROUP BY 
                month,
                year
        ) as subquery'))
        ->select('total_amount', 'month', 'year')
        ->setBindings(['branchId' => $id])
        ->paginate(10);
        
    return view('revenue.monthlyRevenue',['monthlyfees' =>$monthlyfees]);
   }    
    
    public function showDetails($id){
    return view('branches.branch_details',['id'=> $id]);
    }
    public function ShowYearlyFees($id){
        $yearlyfees = DB::table(DB::raw('(
            SELECT 
                SUM(amount) as total_amount,
                year
            FROM 
                monthlyfees_revenues
            WHERE 
                branch_id = :branchId
            GROUP BY 
                year
        ) as subquery'))
        ->select('total_amount','year')
        ->setBindings(['branchId' => $id])
        ->paginate(10);
        
    return view('revenue.yearlyRevenue',['yearlyfees' =>$yearlyfees]);
    }
    public function ShowMonthlyAFees($id){
        $monthlyfees = DB::table(DB::raw('(
            SELECT 
                SUM(amount) as total_amount,
                DATE_FORMAT(fees_for, "%M") as month,
                DATE_FORMAT(fees_for, "%Y") as year
            FROM 
                admissionfees_revenues
            WHERE 
                branch_id = :branchId
            GROUP BY 
                DATE_FORMAT(fees_for, "%Y-%m"),
                DATE_FORMAT(fees_for, "%M"),
                DATE_FORMAT(fees_for, "%Y")
        ) as subquery'))
        ->select('total_amount', 'month', 'year')
        ->setBindings(['branchId' => $id])
        ->paginate(10);
        
        
    return view('revenue.monthlyARevenue',['monthlyfees' =>$monthlyfees]);
    }
    public function ShowYearlyAFees($id){
        $yearlyfees = DB::table(DB::raw('(
            SELECT 
                SUM(amount) as total_amount,
                DATE_FORMAT(fees_for, "%Y") as year
            FROM 
                admissionfees_revenues
            WHERE 
                branch_id = :branchId
            GROUP BY 
                DATE_FORMAT(fees_for, "%Y")
        ) as subquery'))
        ->select('total_amount','year')
        ->setBindings(['branchId' => $id])
        ->paginate(10);
      
    return view('revenue.yearlyARevenue',['yearlyfees' =>$yearlyfees]);
    }

    public function showqauterly(){
        $current_year=date('Y');
        
        $monthly_fees_revenue = DB::table('monthlyfees_revenues')
    ->select(DB::raw('SUM(amount) as total_amount'))
    ->whereMonth('month', '>=', 1)
    ->whereMonth('month', '<=', 4)
    ->whereYear('year', $current_year)
    ->get();

    $monthly_Afees_revenue = DB::table('admissionfees_revenues')
    ->select(DB::raw('SUM(amount) as total_Amount'))
    ->whereMonth('fees_for', '>=', 1)
    ->whereMonth('fees_for', '<=', 4)
    ->whereYear('fees_for', $current_year)
    ->get();

    $Expense = DB::table('expenses')
    ->select(DB::raw('SUM(Amount) as total_Amount'))
    ->whereMonth('created_at', '>=', 1)
    ->whereMonth('created_at', '<=', 4)
    ->where('year',$current_year)
    ->get();

    $salary=DB::table('users')
    ->select(DB::raw('SUM(salary) as total_amount'))
    ->whereMonth('created_at', '>=', 1)
    ->whereMonth('created_at', '<=', 4)
    ->whereYear('created_at',$current_year)
    ->get();
    
       
    return view('quarterlies.q1',['salary'=> $salary,'expense' => $Expense,'monthly_fees_revenue' => $monthly_fees_revenue,'monthly_Afees_revenue' => $monthly_Afees_revenue]);    
    }

    public function showqauterly1(){
        $current_year=date('Y');
        
        $monthly_fees_revenue = DB::table('monthlyfees_revenues')
    ->select(DB::raw('SUM(amount) as total_amount'))
    ->whereMonth('month', '>=', 5)
    ->whereMonth('month', '<=', 8)
    ->whereYear('year', $current_year)
    ->get();

    $monthly_Afees_revenue = DB::table('admissionfees_revenues')
    ->select(DB::raw('SUM(amount) as total_Amount'))
    ->whereMonth('fees_for', '>=', 5)
    ->whereMonth('fees_for', '<=', 8)
    ->whereYear('fees_for', $current_year)
    ->get();

    $Expense = DB::table('expenses')
    ->select(DB::raw('SUM(Amount) as total_Amount'))
    ->whereMonth('created_at', '>=', 5)
    ->whereMonth('created_at', '<=', 8)
    ->where('year',$current_year)
    ->get();

    $salary=DB::table('users')
    ->select(DB::raw('SUM(salary) as total_amount'))
    ->whereMonth('created_at', '>=', 5)
    ->whereMonth('created_at', '<=', 8)
    ->whereYear('created_at',$current_year)
    ->get();
    
       
    return view('quarterlies.q2',['salary'=> $salary,'expense' => $Expense,'monthly_fees_revenue' => $monthly_fees_revenue,'monthly_Afees_revenue' => $monthly_Afees_revenue]);    
    }


    public function showqauterly2(){
        $current_year=date('Y');
        
        $monthly_fees_revenue = DB::table('monthlyfees_revenues')
    ->select(DB::raw('SUM(amount) as total_amount'))
    ->whereMonth('month', '>=', 9)
    ->whereMonth('month', '<=', 12)
    ->whereYear('year', $current_year)
    ->get();

    $monthly_Afees_revenue = DB::table('admissionfees_revenues')
    ->select(DB::raw('SUM(amount) as total_Amount'))
    ->whereMonth('fees_for', '>=', 9)
    ->whereMonth('fees_for', '<=', 12)
    ->whereYear('fees_for', $current_year)
    ->get();

    $Expense = DB::table('expenses')
    ->select(DB::raw('SUM(Amount) as total_Amount'))
    ->whereMonth('created_at', '>=', 9)
    ->whereMonth('created_at', '<=', 12)
    ->where('year',$current_year)
    ->get();

    $salary=DB::table('users')
    ->select(DB::raw('SUM(salary) as total_amount'))
    ->whereMonth('created_at', '>=', 9)
    ->whereMonth('created_at', '<=', 12)
    ->whereYear('created_at',$current_year)
    ->get();
    
       
    return view('quarterlies.q3',['salary'=> $salary,'expense' => $Expense,'monthly_fees_revenue' => $monthly_fees_revenue,'monthly_Afees_revenue' => $monthly_Afees_revenue]);    
    }

    public function showTheFinal(){
        $current_year=date('Y');
        
        $monthly_fees_revenue = DB::table('monthlyfees_revenues')
    ->select(DB::raw('SUM(amount) as total_amount'))
    ->whereYear('year', $current_year)
    ->get();

    $monthly_Afees_revenue = DB::table('admissionfees_revenues')
    ->select(DB::raw('SUM(amount) as total_Amount'))
    ->whereYear('fees_for', $current_year)
    ->get();

    $Expense = DB::table('expenses')
    ->select(DB::raw('SUM(Amount) as total_Amount'))
    ->where('year',$current_year)
    ->get();

    $salary=DB::table('users')
    ->select(DB::raw('SUM(salary) as total_amount'))
    ->whereYear('created_at',$current_year)
    ->get();
    
       
    return view('quarterlies.Y',['salary'=> $salary,'expense' => $Expense,'monthly_fees_revenue' => $monthly_fees_revenue,'monthly_Afees_revenue' => $monthly_Afees_revenue]);    
    }
}
