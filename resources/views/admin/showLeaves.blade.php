@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
    {{-- always include this nav2 first in div with id=content for admin pages --}}
    @include('admin_nav2')
    
    <div class="container">
        <br>
        <br>
        @if($leaves->count()==0)
        <center><h4>Employee has made no leave requests</h4></center>
        <br>
        <br>
        <br>
        @endif
        <div class="row hidden-md-up">
            @foreach ($leaves as $leave)
            @if($leave->status==0)
            <div class="col-sm-12 col-md-4">
                <div class="card mr-10 my-5 mycard" style="">
                    <div class="card-body bg-primary text-white">
                      <h5 class="card-title ">Reason: {{$leave->reason}}</h5>
                      <h6 class="card-subtitle mb-1"> Description: {{$leave->details}}</h6>
                      <p class="card-text text-white">From: {{$leave->from_date}}</p>
                      <p class="card-text text-white">to:  {{$leave->to_date}}</p>
                      <form action="/employees/{{$leave->id}}/approve" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-info btn-sm">Approve</button>
                    
                      </form>
        
                    </div>
                  </div>
            </div>
            @endif
            @endforeach
          </div>
        






<br>




</div> 

</div> 


@endsection