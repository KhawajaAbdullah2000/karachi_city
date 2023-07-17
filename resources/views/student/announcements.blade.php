@extends('master')

@section('content')

@include('student.student_nav')

<div class="container">

    @foreach ($announcements as $ann)
  
    <div class="jumbotron">
        <h1 class="display-6">{{$ann->title}}</h1>
        <hr class="my-2">
        <p class="lead">{{$ann->description}}</p>
        <hr class="my-1">
        <p class="">Created at: {{$ann->created_at}}</p>

     
      </div>
            
    @endforeach


</div> 


@endsection