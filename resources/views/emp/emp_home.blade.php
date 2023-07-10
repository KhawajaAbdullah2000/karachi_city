@extends('master')
@section('content')

<h1>Welcome Employee {{auth()->user()->name}}</h1>

<br>
<a href="{{ route('logout') }}" class="btn btn-primary">Log out</a>
@endsection