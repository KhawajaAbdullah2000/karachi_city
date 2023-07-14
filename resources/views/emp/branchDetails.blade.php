@extends('master')
@section('content')
@include('emp-nav')


<div class="row justify-content-center">
    <div class="col-sm-8">
        <h2>Branch {{$user->branch_name}}</h2>
       <div class="card mt-3 p-3 bg-primary text-white">
        <div class="row">
            <div class="col">
            <p>Branch Address</p>
            <h5>{{$user->address}}</h5>
            <hr>
            <p>Number of Students</p>
            <h5>{{$user->name}}</h5>
            <hr>
            </div>
            <div class="col">
                <p>Number of Employees in Branch
                </p>
                <h5>{{$EmployeeCount}}</h5>
                <hr>
                

            </div>
        </div>
     </div>
  </div>
</div>


<br>

@endsection