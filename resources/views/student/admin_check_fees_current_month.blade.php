@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">

    @include('admin_nav')
    <div id="content" class="p-4 p-md-5">
        {{-- always include this nav2 first in div with id=content for admin pages --}}
        @include('admin_nav2')

        <h1 class='text-center mb-3'>Fees for {{$month}} {{$year}}</h1>


        <table class="table table-responsive table-borderless table-hover table-sm" id="myTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Branch Name</th>
                <th>Payment Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($students as $stud)
              <tr class="table-align ">
                <td>{{$stud->id}}</td>
                <td>{{$stud->first_name}} {{$stud->last_name}}</td>
                <td>{{$stud->email}}</td>
                 <td>{{$stud->branch_name}}</td>
                <td>
                    @if($stud->month==null)
                    <p class="text-danger fw-bold">Not Paid</p>
                @else
                <p class="text-success fw-bold">Paid</p>
                    @endif


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
