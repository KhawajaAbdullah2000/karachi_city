@extends('master')
@section('content')
@include('emp-nav')


<div class="container">
  
    <a class="btn btn-success float-end mb-5" href="/add_new_cash_payment/{{auth()->user()->branch_id}}">
            Add new record for cash</a>

<table class="table table-striped table-responsive" id="myTable">
    <thead >
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Month</th>
            <th>Year</th>
            <th>Image</th>
            <th>paid</th>
        </tr>
        </thead>
        <tbody>
            @foreach($students as $stu)
            <tr class='table-align'>
                <td>{{$stu->studentid}}</td>
                <td>{{$stu->first_name}}{{$stu->last_name}}</td>
                <td>{{$month}}</td>
                <td>{{$year}}</td>
                @if(isset($stu->monthly_fees_ss))
                <td><img src="/monthly_fees/{{$stu->monthly_fees_ss}}" width="50px" height="50px"></td>
                @else
                <td>No image yet</td>
                @endif

                @if($stu->paid==1)
                <td ><button class="btn btn-sm btn-warning">Fees paid</button></td>
                @else
                <td><button class="btn btn-warning btn-sm"><a href="{{route('paid_monthly_fees',['id'=>$stu->studentid,'branch_id'=>auth()->user()->branch_id])}}">Confrim payment</a></button></td>
                @endif
            
            </tr>

            @endforeach
        </tbody>
     
</table>



{{-- <div class="d-flex mt-3">
    <h3 class="text-bold">Total students: </h3>
    <h3>{{ $students->count()}}</h3>

</div>

<div class="d-flex">
    <h3 class="text-bold">Fees not paid by: </h3>
    <h3>{{$notpaid}}</h3>

</div> --}}


</div>





@section('scripts')

<script>

    let table = new DataTable('#myTable',
    {
    language: {
       searchPlaceholder: "student name or id"
    },
    ordering:false

    } 
     );
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