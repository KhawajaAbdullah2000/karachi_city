@extends('master')
@section('content')
@include('emp-nav')

<div class="container">

 <h1 class="text-center">Add new record for {{$month}} {{$year}}</h1>

 <div class="row justify-content-center">
 <div class="col-md-6">



 <div class="card">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="card-body">

        <form action="/add_cash_record_monthly" method="post">
        @csrf

        <div class="form-group ">
            <label for="gender">Student</label>
            <select class="boxstyling bg-primary rounded " name="student_id">
                <option value="">Select Student</option>
                @foreach ($students as $stu)
                <option value="{{$stu->id}}" {{ old('student_id') == $stu->id ? 'selected' : '' }}>{{$stu->id}} {{$stu->first_name}} {{$stu->last_name}}</option>
                @endforeach
            </select>
    <div class="text-center">

            <button type="submit" class="btn btn-success btn-md mt-4">Paid cash</button>
        </div>

        </form>
    </div>
 </div>
</div>
</div>
</div>

@endsection