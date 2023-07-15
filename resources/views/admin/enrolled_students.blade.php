@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
    {{-- always include this nav2 first in div with id=content for admin pages --}}
    @include('admin_nav2')

    <div class="container">

        <h1 class='text-center mb-3'>Enrolled Students</h1>

        <table class="table table-responsive table-borderless table-hover table-sm" id="myTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No.</th>
                <th>Emergency contact</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($students as $stud)
              <tr>
                <td>{{$stud->id}}</td>
                <td>{{$stud->first_name}} {{$stud->last_name}}</td>
                <td>{{$stud->email}}</td>
                <td>{{$stud->phone}}</td>
            
                <td>{{$stud->emergency_name}} {{$stud->emergency_contact}}</td>
        
              </tr>

              @endforeach 
            </tbody>
          </table>
        



    </div>






</div> 

</div> 

@section('scripts')

<script>
    let table = new DataTable('#myTable');
</script>

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