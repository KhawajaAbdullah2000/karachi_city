{{-- @extends('master')
@section('content')
<h1>Welcome Admin {{auth()->user()->name}}</h1>

<br>
<a href="{{ route('logout') }}" class="btn btn-primary">Log out</a>

@endsection --}}

@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
    @include('admin_nav2')
    
<h1>Welcome Admin  {{auth()->user()->name}}</h1>

<br>


</div> 

</div> 


@endsection