@extends('master')
@section('content')
@include('emp-nav')

<div class="container">


    <form action="/monthly_fees_record/{{auth()->user()->branch_id}}" method="get">
        <div class="md-3">
            <input type="text" name="month" id="" placeholder="enter month" value={{request()->input('month')}}>
            <input type="text" name="year" id="" value={{request()->input('year')}}>

            <button type="submit" class="btn btn-sm btn-primary">Search</button>
        </div>
    
    </form>

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
                <td>{{$stu->month}}</td>
                <td>{{$stu->year}}</td>
                @if(isset($stu->monthly_fees_ss))
                <td><img src="/monthly_fees/{{$stu->monthly_fees_ss}}" width="50px" height="50px"></td>
                @else
                <td>No image yet</td>
                @endif

            
        @if(isset($stu->paid))
                @if($stu->paid==1)
                <td ><button class="btn btn-sm btn-warning">Fees paid</button></td>
                @else
                <td><button class="btn btn-danger btn-sm">Not Paid</a></button></td>

                {{-- <td><button class="btn btn-danger btn-sm"><a href="{{route('pay_previous_fees',['id'=>$stu->student_id,'month'=>$stu->month,'year'=>$stu->year])}}">Paid</a></button></td> --}}
                @endif
                @else
@endif
            </tr>

            @endforeach
        </tbody>
     
</table>

{{$students->links()}}


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