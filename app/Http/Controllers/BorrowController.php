<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Item;
use App\Models\User;

class BorrowController extends Controller
{
    public function borrowed($id){
        $borrowed = Borrow::join('items','items.id','=','borrows.item_id')
                            ->join('users','users.id','=','borrows.borrowed_by')
                            ->where('borrows.branch_id',$id)
                            ->get(['borrows.id','users.name','items.item_name','borrows.created_at']);
        $count = Borrow::where('branch_id',$id)->count();
        return view('emp.borrowed',['borrowed'=>$borrowed,'count'=>$count]);

    }

    public function borrow_item($id){
        $items = Item::where('branch_id',$id)->get();
        $users = User::where('branch_id',$id)->get();
        return view('emp.borrow_item',['items'=>$items,'users'=>$users]);
    }

    public function add_borrow($id,Request $request){
        $request->validate([
            'borrowed_by' => 'required',
            'item_id' => 'required'
        ]);
       $borrow = new Borrow;
       $borrow->branch_id = $id;
       $borrow->item_id = $request->item_id;
       $borrow->borrowed_by = $request->borrowed_by; 
       $borrow->save();

       return redirect()->route('borrowed_items',['id'=>$id]);

    }

    public function destroy($id){
        $borrow = Borrow::where('id',$id)->first();
        $branch_id = $borrow->branch_id;
        $borrow->delete();

        return redirect()->route('borrowed_items',['id'=>$branch_id]);
    }

}
