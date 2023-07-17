@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
    {{-- always include this nav2 first in div with id=content for admin pages --}}
    @include('admin_nav2')
    {{-- @if($message=Session::get('success'))
    <div class="alert alert-success alert-block">
        <strong>{{$message}}</strong>

    </div>

    @endif --}}
<h1>Welcome Admin  {{auth()->user()->name}}</h1>

<br>


</div> 

</div> 

@section('scripts')
 
@if(Session::has('success'))
<script>
    swal({
  title: "{{Session::get('success')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 4000,
    });
</script> 
@endif

@endsection


@endsection