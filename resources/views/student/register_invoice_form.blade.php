@extends('master')

@section('content')



<div class="wrapper d-flex align-items-stretch">
    @include('admin_nav')

    <div id="content" class="p-4 p-md-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h3 class='text-center mb-3'>Send Registeration Invoice to <span class="fw-bold">
                {{ $student->first_name }} {{ $student->last_name }}</span>
        </h3>
        <h3 class="text-center">Branch: {{$student->branch_name}}</h3>

        <form action="/send_registeration_invoice/{{$student->id}}" method="POST">
            @csrf
            <div class="row">

                <div class="form-group col-lg-6">
                    <label for="">Registeraton Fees: *</label>
                    <input class="form-control" type="number" name="reg_fees" id="">
                </div>
            </div>

            <div class="row mt-4">

                <div class="form-group col-lg-6">
                    <label for="gender">Month 1: *</label>
                    <select class="boxstyling bg-primary rounded" name="month1">
                        <option value="">Select..</option>
                        <option value="January" {{ old('month1') == 'January' ? 'selected' : '' }}>January</option>
                        <option value="February" {{ old('month1') == 'February' ? 'selected' : '' }}>February</option>
                        <option value="March" {{ old('month1') == 'March' ? 'selected' : '' }}>March</option>
                        <option value="April" {{ old('month1') == 'April' ? 'selected' : '' }}>April</option>
                        <option value="May" {{ old('month1') == 'May' ? 'selected' : '' }}>May</option>
                        <option value="June" {{ old('month1') == 'June' ? 'selected' : '' }}>June</option>
                        <option value="July" {{ old('month1') == 'July' ? 'selected' : '' }}>July</option>
                        <option value="August" {{ old('month1') == 'August' ? 'selected' : '' }}>August</option>
                        <option value="September" {{ old('month1') == 'September' ? 'selected' : '' }}>September</option>
                        <option value="October" {{ old('month1') == 'October' ? 'selected' : '' }}>October</option>
                        <option value="November" {{ old('month1') == 'November' ? 'selected' : '' }}>November</option>
                        <option value="December" {{ old('month1') == 'December' ? 'selected' : '' }}>December</option>
                    </select>
                </div>


            </div>

            <div class="row mt-4">
                <div class="col-lg-6">
                    <label for="">Month 1 Fees: *</label>
                    <input type="number" name="month1_fees" id="">
                </div>

            </div>

            <div class="row mt-4">

                <div class="form-group col-lg-6">
                    <label for="gender">Month 2: (Optional)</label>
                    <select class="boxstyling bg-primary rounded" name="month2">
                        <option value="">Select..</option>
                        <option value="January" {{ old('month1') == 'January' ? 'selected' : '' }}>January</option>
                        <option value="February" {{ old('month1') == 'February' ? 'selected' : '' }}>February</option>
                        <option value="March" {{ old('month1') == 'March' ? 'selected' : '' }}>March</option>
                        <option value="April" {{ old('month1') == 'April' ? 'selected' : '' }}>April</option>
                        <option value="May" {{ old('month1') == 'May' ? 'selected' : '' }}>May</option>
                        <option value="June" {{ old('month1') == 'June' ? 'selected' : '' }}>June</option>
                        <option value="July" {{ old('month1') == 'July' ? 'selected' : '' }}>July</option>
                        <option value="August" {{ old('month1') == 'August' ? 'selected' : '' }}>August</option>
                        <option value="September" {{ old('month1') == 'September' ? 'selected' : '' }}>September</option>
                        <option value="October" {{ old('month1') == 'October' ? 'selected' : '' }}>October</option>
                        <option value="November" {{ old('month1') == 'November' ? 'selected' : '' }}>November</option>
                        <option value="December" {{ old('month1') == 'December' ? 'selected' : '' }}>December</option>
                    </select>
                </div>


            </div>

            <div class="row mt-4">
                <div class="col-lg-6">
                    <label for="">Month 2 Fees: (Optional)</label>
                    <input type="number" name="month2_fees" id="">
                </div>

            </div>

            <button type="submit" class="btn btn-md btn-success mt-3">Send Invoice</button>




        </form>






    </div>


</div>


@section('scripts')
    <script>
        let table = new DataTable('#myTable', {
            ordering: false
        });
    </script>
@endsection




@endsection
