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
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($devices as $device)
          <tr>
            <td>{{$device->id}}</td>
            <td>{{$device->ip}}</td>
            <td>{{$device->model_name}}</td>
            <td>{{$device->branch_name}}</td>
            <td>
                @if($device->status==0)
                <form method="POST" action="zkTeco/{{$device->id}}/Connect" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success btn-sm">Connect</button>
                    </form>
                @else
                <form method="POST" action="zkTeco/{{$device->id}}/Disconnect" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger btn-sm">Disconnect</button>
                    </form>
                <a href="zkTeco/{{$device->id}}/test" class="btn btn-success btn-sm d-inline">Test</a>
                @endif
            </td>    
            <td>    
                <a href="zkTeco/{{$device->id}}/update" class="btn btn-dark btn-sm">Edit</a>
                <form method="POST" action="zkTeco/{{$device->id}}/delete" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
          </tr>
          @endforeach 
        </tbody>
      </table>
    

    @endif

    <br>
    <br>
    <a href="zktecoDevice/create" class="btn btn-info btn-sm text-white" role="button">Add New Device</a>



</div> 


@endsection    