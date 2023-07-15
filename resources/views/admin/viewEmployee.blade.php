@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
    {{-- always include this nav2 first in div with id=content for admin pages --}}
    @include('admin_nav2')
    @if($message=Session::get('success'))
    <div class="alert alert-success alert-block">
        <strong>{{$message}}</strong>

    </div>

    @endif
    <div class="row justify-content-center">
        <div class="col-sm-8">
           <div class="card mt-3 p-3 bg-primary text-white">
            <div class="row">
                <div class="col">
                  <p>Name</p>
                  <h5>{{$user->name}}</h5>
                  <hr>
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
                  <p>Salary</p>
                  <h5>{{$user->salary}} Rs.</h5>
                  <hr>
                </div>
                <div class="col">
                    <h5>CNIC front</h5>
                    <img src="/cnic/{{$user->cnicFront}}" alt="CNIC front image not uploaded" class="rounded" width="100%"/>
                    <br>
                    <br>
                    <hr>
                    <br>
                    <h5>CNIC back</h5>
                    <img src="/cnic/{{$user->cnicBack}}" alt="CNIC back image not uploaded" class="rounded" width="100%"/>
                </div>
              </div>
           </div>
        </div>
    </div>
<br>


</div> 

</div> 


@endsection