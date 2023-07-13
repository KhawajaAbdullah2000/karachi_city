@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
    {{-- always include this nav2 first in div with id=content for admin pages --}}
    @include('admin_nav2')
    
<h1>Employees</h1>
<table class="table table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone No.</th>
        <th>CNIC</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
      @if ($user->role==0)
      <tr>
        <td>{{$user->id}}</td>
        <td><a href="employees/{{$user->id}}/display">{{$user->name}}</a></td>
        <td>{{$user->email}}</td>
        <td>{{$user->phone}}</td>
        <td>{{$user->cnic}}</td>
        <td>
            <a href="employees/{{$user->id}}/update" class="btn btn-dark btn-sm">Edit</a>
            <form method="POST" action="employees/{{$user->id}}/delete" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
      </tr>
      @endif
      @endforeach 
    </tbody>
  </table>

<br>

<a href="employees/create" class="btn btn-info btn-sm text-white" role="button">Add New Employee</a>
</div> 
</div> 


@endsection