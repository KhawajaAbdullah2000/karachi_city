<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Branches;
use Spatie\Permission\Models\Role;

class BranchController extends Controller
{
    public function showbranches(){
      $branch= Branches::all();
      return view('branches.displaybranches',['branches' => $branch]);

    }
    public function destroy(request $request){
        $branch_del = Branches::where('id',$request->category_delete_id)->first();
        $branch_del->delete();
        return back();
    }
    public function create(){
        $user=User::all();
      return view('branches.add_new_branch',['user' => $user]);
    }

    public function store(Request $request){
      $role = Role::first();
      if(is_null($role)){
        $role = Role::create(['name'=>'manager']);
      }
      $request->validate([
          'name' => 'required',
          'address' => 'required',
          
      ]);
      $branch = new Branches;
      $branch->branch_name= $request->name;
      $branch->address = $request->address;
      $branch->manager_id=$request->manager_id;
      $user = User::where('id',$request->manager_id)->first();
      $user->assignRole($role);
      $branch->save();
      return redirect()->route('branches.create')->with('status','New Branch added successfully!');
  }
}
