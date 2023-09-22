@extends('master')
@section('content')
@include('emp-nav')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8">
           <div class="card mt-3 p-3 bg-primary text-white">
               <form method="POST" action="/emp_items/{{auth()->user()->branch_id}}/addborrow" >
                   @csrf
                   @method('POST')
                   <div class="form-group mt-3 mb-3">
                    <label>Borrowed by</label>
                    <select name="borrowed_by" id="borrowed_by" class="boxstyling bg-primary rounded">
                        @foreach($users as $user)
                            @if($user->role === 0)
                                <option value="{{$user->id}}">{{$user->name}} {{$user->id}}</option>        
                            @endif
                        @endforeach
                    </select> 
                   </div>
                   
                   <div class="form-group mt-3 mb-3">
                    <label>Item</label>
                    <select name="item_id" id="item_id" class="boxstyling bg-primary rounded">
                        @foreach($items as $item)
                        @if($item->quantity!=0)
                                <option value="{{$item->id}}">{{$item->item_name}} {{$item->quantity}}</option> 
                        @endif
                        @endforeach
                    </select> 
                   </div>
                
                
                <button type="submit" class="btn btn-dark mt-3">Submit</button>
                </form>
           
            </div>    
         </div>
     </div>
     

</div>

<br>

@endsection