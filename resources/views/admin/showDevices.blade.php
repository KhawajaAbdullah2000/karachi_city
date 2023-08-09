@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
    {{-- always include this nav2 first in div with id=content for admin pages --}}
    @include('admin_nav2')
    @if($devices->count()==0)
    <div class="container">
        <h1>No Devices Connected Yet</h1>
        
    </div>
    @else
    <h1>Devices</h1>
    <table class="table table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>IP</th>
            <th>Model Name</th>
            <th>Branch</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($devices as $device)
          <tr>
            <td>{{$device->id}}</td>
            <td>{{$device->ip}}</td>
            <td>{{$device->model_name}}</td>
            <td>{{$device->branch_name}}</td>
          </tr>
          @endforeach 
        </tbody>
      </table>
    

    @endif

    <br>
    <br>


</div> 


@endsection    