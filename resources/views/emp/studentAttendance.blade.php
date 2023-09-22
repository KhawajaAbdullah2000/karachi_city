@extends('master')

@section('content')
    
@include('emp-nav')


    <div class="container">

        <h1 class='text-center mb-3'>Student Attendance</h1>

        <table class="table table-responsive table-borderless table-hover table-sm" id="myTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Time</th>
                <th>Date</th>
                <th>Check Out</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($attendance as $att)
              <tr class="table-align">
                <td>{{$att->id}}</td>
                <td>{{$att->first_name}} {{$att->last_name}}</td>
                <td>{{$att->Attendance_time}}</td>
                <td>{{$att->Attendance_date}}</td>
                @if($att->checked_in==0)
                <td>Checked Out</td>
                @else
                <td></td>    
                @endif
        
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


@endsection




@endsection