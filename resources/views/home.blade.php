@extends('master')

@section('content')



@if(Session::has('status'))
<h3 class="text-secondary">{{Session::get('status')}}</h3>
@endif
<h2>Employee Login</h2>

<a href="{{route('login_form')}}">Employee Login</a>
<a href="{{route('student_login')}}">Student Login</a>





@endsection