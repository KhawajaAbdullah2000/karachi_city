<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Branches;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;

class BranchController extends Controller
{
    public function showbranches(){
      $branch= Branches::leftjoin('users','users.id','branches.manager_id')->select('branches.id','branches.branch_name','branches.address','users.name')->get();
    
      return view('branches.displaybranches',['branches' => $branch]);

    }
    public function destroy(request $request){
        $branch_del = Branches::where('id',$request->category_delete_id)->first();
        $user = User::where('id',$branch_del->manager_id)->first();
        $user->removeRole('manager');
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
           'address' => 'required|unique:branches,address',
          
       ]);
      $branch = new Branches;
      $branch->branch_name= $request->name;
      $branch->address = $request->address;
      $branch->save();

      return redirect()->route('branches.create')->with('status','New Branch added successfully!');
  }
    
  public function edit($id){
      $branches=Branches::where('id',$id)->first();
      $user=User::where('branch_id',$branches->id)->get();
      return view('branches.edit_branch',[ 'branches' => $branches,'user' => $user]);

    }

    
    public function update(Request $request,$id){
      $request->validate([
        'name' => ['required'],
        'address' => ['required',Rule::unique('branches')->ignore($id,'id')],
    ]);
    $branch= Branches::where('id',$id)->first();
    $branch->branch_name= $request->name;
    $branch->address = $request->address;
    $branch->manager_id=$request->manager_id;
    $manager = User::where('id',$branch->manager_id)->first();
    if(isset($manager)){
      $user = User::role('manager')->where('branch_id',$branch->id)->first();
      if(isset($user)){
       $user->removeRole('manager');
      }
      $manager->assignRole('manager');
    }
    $branch->save();
    return back()->with('status','Branch updated successfully!');
  }


 
}
