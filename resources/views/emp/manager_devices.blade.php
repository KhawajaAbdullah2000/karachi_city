@extends('master')
@section('content')
@include('emp-nav')

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
@if($device->count()==0)
    <div class="container">
        <h1>No Devices Connected Yet</h1>
        <br>
        <br>
        <a href="/zktecoDevice/create" class="btn btn-info btn-sm text-white">Add New Device</a>
    </div>
    @else
    <div class="container">
    <h1>Devices</h1>
    <table class="table table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>IP</th>
            <th>Model Name</th>
            <th>Branch</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{$device->id}}</td>
            <td>{{$device->ip}}</td>
            <td>{{$device->model_name}}</td>
            <td>{{$device->branch_name}}</td>
            <td>
                @if($device->status==0)
                <form method="POST" action="/zkTeco/{{$device->id}}/Connect" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success btn-sm">Connect</button>
                    </form>
                @else
                <form method="POST" action="/zkTeco/{{$device->id}}/Disconnect" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger btn-sm">Disconnect</button>
                    </form>
                <a href="/zkTeco/{{$device->id}}/test" class="btn btn-success btn-sm d-inline">Test</a>
                @endif
            </td>    
            <td>    
                <a href="zkTeco/{{$device->id}}/update" class="btn btn-dark btn-sm">Edit</a>
                <form method="POST" action="zkTeco/{{$device->id}}/delete" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>

          </tr>
        </tbody>
      </table>
    <br>
    <br>

    <a href="/zkteco/{{$device->id}}/addStudents" class="btn btn-info btn-sm text-white">Add Students to Device</a>
    <a href="/zkteco/{{$device->id}}/getAttendance" class="btn btn-info btn-sm d-inline text-white">Update Attendance Log</a>


    @endif

    <br>
    <br>


</div> 


<br>

@endsection