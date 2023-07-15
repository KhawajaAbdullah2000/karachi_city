@extends('master')
@section('content')
@include('emp-nav')


<div class="container">
<br>
<br>
@if($leaves->count()==0)
<center><h4>You have no Leave requests</h4></center>
<br>
<br>
<br>
@endif
<div class="row hidden-md-up">
    @foreach ($leaves as $leave)
    <div class="col-sm-12 col-md-4">
        <div class="card mr-10 my-5 mycard" style="">
            <div class="card-body bg-primary text-white">
              <h5 class="card-title ">Reason: {{$leave->reason}}</h5>
              <h6 class="card-subtitle mb-1"> Description: {{$leave->details}}</h6>
              <p class="card-text text-white">From: {{$leave->from_date}}</p>
              <p class="card-text text-white">to:  {{$leave->to_date}}</p>
              @if($leave->status==0)
              <p class="card-text text-danger">Not approved</p>
              @endif

              @if($leave->status==1)
              <p class="card-text text-warning">Approved</p>
              @endif

            </div>
          </div>
    </div>
 
    @endforeach
  </div>

<a href="/emp_home/{{auth()->user()->id}}/applyLeave" class="btn btn-info btn-lg text-white">Apply For Leaves</a>

</div>

<br>

@endsection