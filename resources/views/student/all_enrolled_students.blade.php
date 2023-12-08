@extends('master')

@section('content')



<div class="wrapper d-flex align-items-stretch">

    @include('admin_nav')
    <div id="content" class="p-4 p-md-5">
        {{-- always include this nav2 first in div with id=content for admin pages --}}
        @include('admin_nav2')

        <h1 class='text-center mb-3'>Enrolled Students</h1>


        <table class="table table-responsive table-borderless table-hover table-sm" id="myTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No.</th>
                <th>Branch Name</th>
                <th >Send Invoice</th>
                <th>Payment</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($students as $stud)
              <tr class="table-align ">
                <td>{{$stud->id}}</td>
                <td>{{$stud->first_name}} {{$stud->last_name}}</td>
                <td>{{$stud->email}}</td>
                <td>{{$stud->phone}}</td>
                <td>{{$stud->branch->branch_name}}</td>


                <td>
                    <a href="/student_monthly_invoice/{{$stud->id}}" class="btn btn-warning btn-sm">Send Monthly Fee invoice</a>
                </td>
                <td>
                    <a href="/student_monthly_fees_paid/{{$stud->id}}" class="btn btn-success btn-sm">Confirm Monthly fees payment</a>

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
