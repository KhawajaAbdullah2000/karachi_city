@extends('master')

@section('content')

@if(Session::has('status'))
<h3 class="text-secondary">{{Session::get('status')}}</h3>
@endif

@include('home-nav')
  <div class="homepage">

    <div class="homepage-content">
    <h1>KARACHI CITY</h1>
    <p>We have amazing things in store for you.</p>
    <a href="{{route('register')}}" class="btn btn-warning btn-lg">Register Yourself</a>
    </div>

  </div>
  

@endsection