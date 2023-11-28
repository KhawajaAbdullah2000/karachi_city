@extends('master')

@section('content')



<div class="wrapper d-flex align-items-stretch">

    @include('admin_nav')
    <div id="content" class="p-4 p-md-5">
        {{-- always include this nav2 first in div with id=content for admin pages --}}
        @include('admin_nav2')

        <h1 class='text-center mb-3'>Registered Students</h1>

        <table class="table table-responsive table-borderless table-hover table-sm" id="myTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No.</th>
                <th>Admission fees paid receipt</th>
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
                @if(isset($stud->admission_fees_ss))
                <td><img src="/admission_fees/{{$stud->admission_fees_ss}}" alt="admission fees" width="50" height="50"></td>
               @else
               <td><h5><span class="badge bg-primary rounded-pill ">No image yet</span></h5></td>
                @endif
                <td>
                    <a href="/student_admission_invoice/{{$stud->id}}" class="btn btn-warning btn-sm">Send Registeration invoice</a>

                    <a href="/student_admission_fees_paid/{{$stud->id}}" class="btn btn-success btn-sm">Confirm admission fees payment</a>
                    <a href="/delete_student/{{$stud->id}}" class="btn btn-danger btn-sm">Delete</a>

                  </td>
              </tr>

              @endforeach
            </tbody>
          </table>



        </div>
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
