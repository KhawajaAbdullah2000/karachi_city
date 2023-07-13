@extends('master')

@section('content')

@section('class','cont')

@if(Session::has('status'))
<h3 class="text-secondary">{{Session::get('status')}}</h3>
@endif

@if(Session::has('registered'))
<h3 class="text-primary">{{Session::get('registered')}}</h3>
@endif

@include('home-nav')


  

  <div class="homepage">

    <div class="homepage-content">
    <h1 classs="home-heading">KARACHI CITY</h1>
    <p>We have amazing things in store for you.</p>
    <a href="{{route('register')}}" class="btn btn-warning btn-lg">Register Yourself</a>
    </div>

  </div>
  

  @section('scripts')

        @if(Session::has('registered'))
              <script>
                  swal({
                title: "Kindly check your email for more details.",
                icon: "success",
                closeOnClickOutside: true,
                timer: 4000,
                  });
              </script> 
      @endif

  @endsection 

@endsection