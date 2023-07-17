@extends('master')
@section('content')
@include('emp-nav')


<div class="row justify-content-center">
    <div class="col-sm-8">
       <div class="card mt-3 p-3 bg-primary text-white">
           <form method="POST" action="/emp_items/{{auth()->user()->branch_id}}/store" >
               @csrf
               @method('POST')
               <div class="form-group">
                <label>Item Name</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}" />
                @if($errors->has('name'))
                   <span class="text-danger">{{$errors->first('name')}}</span>
                @endif
               </div>
                <button type="submit" class="btn btn-dark mt-3">Submit</button>
           </form>
           
       </div>    
    </div>
</div>



@endsection