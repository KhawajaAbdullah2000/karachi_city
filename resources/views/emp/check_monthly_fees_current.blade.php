@extends('master')
@section('content')
@include('emp-nav')


<div class="container">


<table class="table table-striped table-responsive">
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
                <td>{{$stu->id}}</td>
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
                <td><button class="btn btn-danger btn-sm"><a href="{{route('paid_monthly_fees',['id'=>$stu->id,'branch_id'=>auth()->user()->branch_id])}}">Paid</a></button></td>
                @endif
            </tr>

            @endforeach
        </tbody>
</table>

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