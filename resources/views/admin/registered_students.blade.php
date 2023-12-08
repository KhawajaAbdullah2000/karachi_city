@extends('master')

@section('content')


@include('emp-nav')



    <div class="container">
        <h1 class='text-center mb-3'>Registered Students</h1>

        <table class="table table-responsive table-borderless table-hover table-sm" id="myTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No.</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($students as $stud)
              <tr class="table-align ">
                <td>{{$stud->id}}</td>
                <td>{{$stud->first_name}} {{$stud->last_name}}</td>
                <td>{{$stud->email}}</td>
                <td>{{$stud->phone}}</td>

                <td>
                    <a href="/delete_student/{{$stud->id}}" class="btn btn-danger btn-sm">Delete</a>

                  </td>
              </tr>

              @endforeach
            </tbody>
          </table>




    </div>




@section('scripts')

<script>
    let table = new DataTable('#myTable',{
      ordering:false
    });
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

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "error",
  closeOnClickOutside: true,
  timer: 4000,
    });
</script>
@endif


@endsection




@endsection
