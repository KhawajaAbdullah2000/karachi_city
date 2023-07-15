@extends('master')

@section('content')

    
@include('emp-nav')



    <div class="container">
        <h1 class='text-center mb-3'>Registered Students</h1>

        <table class="table table-responsive table-borderless table-hover table-sm" id="myTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No.</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($students as $stud)
              <tr>
                <td>{{$stud->id}}</td>
                <td>{{$stud->first_name}} {{$stud->last_name}}</td>
                <td>{{$stud->email}}</td>
                <td>{{$stud->phone}}</td>
                <td>
                    <a href="/student_admission_fees_paid/{{$stud->id}}/{{$stud->branch_id}}" class="btn btn-warning btn-sm">Admission Fees paid</a>
                </td>
              </tr>

              @endforeach 
            </tbody>
          </table>
        



    </div>




@section('scripts')

<script>
    let table = new DataTable('#myTable');
</script>


@endsection




@endsection