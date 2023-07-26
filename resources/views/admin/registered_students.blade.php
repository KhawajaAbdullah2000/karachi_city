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
                <th>Admission fees paid receipt</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($students as $stud)
              <tr class="table-align ">
                <td>{{$stud->id}}</td>
                <td>{{$stud->first_name}} {{$stud->last_name}}</td>
                <td>{{$stud->email}}</td>
                <td>{{$stud->phone}}</td>
                @if(isset($stud->admission_fees_ss))
                <td><img src="/admission_fees/{{$stud->admission_fees_ss}}" alt="admission fees" width="50" height="50"></td>
               @else
               <td><h5><span class="badge bg-primary rounded-pill ">No image yet</span></h5></td>
                @endif
                <td>
                    <a href="/student_admission_fees_paid/{{$stud->id}}/{{$stud->branch_id}}" class="btn btn-warning btn-sm">Confirm admission fees payment</a>
                </td>
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


@endsection




@endsection