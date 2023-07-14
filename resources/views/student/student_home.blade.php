@extends('master')

@section('content')

@include('student.student_nav')

<div class="container">


    
<h1>Welcome Student  {{auth('student')->user()->first_name}}</h1>

<a href="{{ url('/student_logout') }}" class="btn btn-primary">Log out</a>



</div> 



@endsection