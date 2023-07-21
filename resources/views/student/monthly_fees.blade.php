@extends('master')

@section('content')

@include('student.student_nav')

<div class="container">

    <table class="table table-responsive table-sm">
        <thead>
            <tr>
                <th >Fees screenshot</th>
                <th >Month</th>
                <th >Year</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fees as $fee)
            <tr class="table-align">
                <td><img src="/monthly_fees/{{$fee->monthly_fees_ss}}" width="50px" height="50px"></td>
                <td>{{$fee->month}}</td>
                <td>{{$fee->year}}</td>
                @if($fee->paid==0)
                <td>Wating for approval </td>    
                @else
                <td>paid </td>                  
             @endif
            </tr>
    @endforeach
        </tbody>
    </table>
</div>


@endsection