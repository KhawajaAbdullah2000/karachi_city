@extends('master')
@section('content')
@include('emp-nav')

<div class="container">
    @if($count==0)
<h1 class="text-center">No Expenses Added Yet</h1>
    @else
    <table class="table table-hover">
      <thead>
          <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          
          @foreach ($expenses as $expenses)
          <tr>
            <td>{{$expenses->id}}</td>
            <td>{{$expenses->Category}}</td>
            <td>PKR {{number_format($expenses->Amount, 2)}}</td>
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
         <tr>
          <td>{{$count+1}}</td>
          <td>Total Salary</td>
          <td>PKR {{number_format($salary, 2)}}</td>
        </tr> 
        </tbody>
        
      </table>
      @if(Session::has('error'))
      <p class="text-danger">{{Session::get('error')}}</p>
       @endif 
    
      @endif
    <a href="/expenses_home/{{auth()->user()->branch_id}}/add" class="btn btn-info btn-lg text-white">Add a new expense</a>
    
</div>

@endsection