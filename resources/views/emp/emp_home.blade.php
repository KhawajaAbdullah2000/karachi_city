@extends('master')
@section('content')
@include('emp-nav')

<div class="row justify-content-center">
    <div class="col-sm-8">
        @if($message=Session::get('success'))
    <div class="alert alert-success alert-block">
        <strong>{{$message}}</strong>
    </div>
    @endif
        <h2>Welcome {{$user->name}}</h2>
       <div class="card mt-3 p-3 bg-primary text-white">
        <div class="row">
            <div class="col">
              <p>Name</p>
              <h5>{{$user->name}}</h5>
              <hr>
              @role('manager')
              <p>Role</p>
              <h5>Branch Manager</h5>
              <hr>
              @endrole
              <p>Email</p>
              <h5>{{$user->email}}</h5>
              <hr>
              <p>Phone Number</p>
              <h5>{{$user->phone}}</h5>
              <hr>
              <p>CNIC No.</p>
              <h5>{{$user->cnic}}</h5>
              <hr>
              <p>Branch Name</p>
              <h5>{{$user->branch_name}},{{$user->address}}</h5>
              <hr>
            </div>
            <div class="col">
                <h5>CNIC front</h5>
                <img src="/cnic/{{$user->cnicFront}}" alt="CNIC Front image not uploaded" class="rounded" width="100%"/>
                <br>
                <br>
                <hr>
                <br>
                <h5>CNIC back</h5>
                <img src="/cnic/{{$user->cnicBack}}" alt="CNIC Back image not uploaded" class="rounded" width="100%"/>
            </div>
          </div>
       </div>
       <a href='/emp_home/{{auth()->user()->id}}/edit' class="btn btn-info btn-bg mt-3 text-white">Edit Details</a>
    </div>
</div>

<br>

@endsection