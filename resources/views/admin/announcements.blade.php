@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
    {{-- always include this nav2 first in div with id=content for admin pages --}}
    @include('admin_nav2')
    
<h1>Announcements</h1>
<table class="table table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($announcements as $ann)
      <tr>
        <td>{{$ann->id}}</td>
        <td>{{$ann->title}}</td>
        <td>{{$ann->description}}</td>
        <td>
            <a href="/edit_announcement/{{$ann->id}}" class="btn btn-dark btn-sm">Edit</a>
            <form method="POST" action="/delete_announcement/{{$ann->id}}" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
      </tr>
      @endforeach 
    </tbody>

  </table>

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