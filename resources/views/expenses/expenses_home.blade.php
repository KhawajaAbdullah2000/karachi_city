
@extends('master')
@section('content')
@include('emp-nav')
@if(session()->has('status'))
                 
    <div class="alert alert-success">
      {{session('status')}}
    </div>
 @endif   
<div class="container">
    @if($count==0)
<h1 class="text-center">No Expenses Added Yet</h1>
    @else
    <div class="row">
    {{$expenses->links()}}
    </div>
    <table class="table table-hover">
      <thead>
          <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Date&Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          
          @foreach ($expenses as $expenses)
          <tr>
            
            <td>{{$loop->index+1}}</td>
            <td>{{$expenses->Category}}</td>
            <td>PKR {{number_format($expenses->Amount, 2)}}</td>
            <td>{{$expenses->created_at}}</td>
            <td>
                <a href="" class="btn btn-dark btn-sm">Edit</a>
                <form method="POST" action="" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
          </tr>
         @endforeach
    
      </table>
      
      @if(Session::has('error'))
      <p class="text-danger">{{Session::get('error')}}</p>
       @endif 
    
      @endif
    <a href="/expenses_home/{{auth()->user()->branch_id}}/add" class="btn btn-info btn-lg text-white">Add a new expense</a>
    
</div>

@endsection