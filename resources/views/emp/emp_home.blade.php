@extends('master')
@section('content')
@include('emp-nav')
<h1>Welcome {{auth()->user()->name}}</h1>

<br>

@endsection