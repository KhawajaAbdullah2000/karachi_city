@extends('master')
@section('content')
@include('emp-nav')
@if(session()->has('status'))

     
      <div class="alert alert-success">
         {{session('status')}}
      
         <a href="/expenses_home/{{auth()->user()->branch_id}}">
         <button type="button" class="btn btn-secondary btn-sm">OK</button>
         </a>
         </div>
 

@endif
<div class="row justify-content-center">
    <div class="col-sm-8">
       <div class="card mt-3 p-3 bg-primary text-white">
           <form method="POST" action="/expenses_home/{{$expenses->id}}/{{$expenses->branch_id}}/update">
               @csrf
               @method('PUT')
               <div class="form-group">
                <label>Category</label>
                <input type="text" name="Category" class="form-control" value="{{old('Category', $expenses->Category)}}" />
                @if($errors->has('Category'))
                   <span class="text-danger">{{$errors->first('Category')}}</span>
                @endif
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="text" name="Amount" class="form-control" value="{{old('Amount',$expenses->Amount)}}" />
                @if($errors->has('Amount'))
                   <span class="text-danger">{{$errors->first('Amount')}}</span>
                @endif
               </div>
            <button type="submit" class="btn btn-dark mt-3">Submit</button>
           </form>
           
       </div>   
                 
    </div>
</div>   

@endsection