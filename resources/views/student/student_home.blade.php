@extends('master')

@section('content')

@include('student.student_nav')

<div class="container">
    @if(auth('student')->user()->unreadnotifications)
    @foreach (auth('student')->user()->unreadnotifications as $notifications)
    <div class="notify p-3 text-center rounded">
        <b> {{$notifications->data['title']}}</b>
            <a href="{{route('read_notification',$notifications->id)}}" class="btn btn-sm btn-success">Mark as read</a>
        @endforeach
        
        </div>
        @endif
        

    <div class="row justify-content-center">
        <div class="col-sm-8">

            <h2 class="text-center">Welcome {{auth('student')->user()->first_name}}</h2>
           <div class="card mt-3 p-3 stud-card text-white text-bold">
            <div class="row">
                <div class="col">
                  <p>Name</p>
                  <h5>{{auth('student')->user()->first_name}} {{auth('student')->user()->last_name}}</h5>
                  <p>Email</p>
                  <h5>{{auth('student')->user()->email}}</h5>
                  <hr>
                  <p>Phone Number</p>
                  <h5>{{auth('student')->user()->phone}}</h5>
                  <hr>
                  <p>Date of birth</p>
                  <h5>{{auth('student')->user()->DOB}}</h5>
                  <hr>
                  <p>Branch Name</p>
                  <h5>{{auth('student')->user()->branch->branch_name}},{{auth('student')->user()->branch->address}}</h5>
                  <hr>
                  <p>Emergency Contact Details</p>
                  <h5>{{auth('student')->user()->emergency_name}}: {{auth('student')->user()->emergency_contact}}</h5>
                  <hr>

                </div>
              
              </div>
           </div>
           <a href='{{route('student_edit_form',['id'=>auth('student')->user()->id])}}' class="btn btn-info btn-bg mt-3 text-white">Edit Details</a>
        </div>
    </div>



</div> 


@section('scripts')

@if(Session::has('updated'))
<script>
    swal({
  title: "{{Session::get('updated')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 4000,
    });
</script> 
@endif

@endsection

@endsection