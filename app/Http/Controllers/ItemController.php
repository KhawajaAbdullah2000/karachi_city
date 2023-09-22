<?php

namespace App\Http\Controllers;
use App\Models\Item;
use App\Models\Branches;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function emp_items($id){
        $items=Item::where('branch_id',$id)->get();
        //Implement Count Logic
        $count=Item::where('branch_id',$id)->count();
        return view('emp.emp_items',['items'=>$items,'count'=>$count]);
    }
    public function items_add($id){
        return view('emp.item_add');
    }
    public function items_store(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'quantity' => 'required'
        ]);
        try{
            $item = new Item;
            $item->item_name=$request->name;
            $item->quantity=$request->quantity;
            $item->branch_id=$id;
            $item->save();
            return redirect()->route('emp_items',['id'=>$id]);
        }catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                return redirect()->route('emp_items',['id'=>$id])->with('error','This item already exist');

            }
        }
    
    }
    public function items_edit($id){
        $item = Item::where('id',$id)->first();
        return view('emp.item_edit',['item'=>$item]);
    }
    public function items_update(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'quantity' => 'required'
        ]);
        $item = Item::where('id',$id)->first();
        $item->item_name = $request->name;
        $item->quantity = $request->quantity;
         $item->save();
         return redirect()->route('emp_items',['id'=>$item->branch_id]);
    }
    public function items_destroy($id){
        $item =Item::where('id',$id)->first();
        $item->delete();

        return back();
    }
}
