@extends('master')

@section('content')

@include('student.student_nav')

<div class="container">

    @if(isset($student->admission_fees_ss))
<div class="text-center">


    <h3>Image uploaded. You will be registered student once the image is approved or visit your branch</h3>
    <img src="/admission_fees/{{$student->admission_fees_ss}}"  width="300" height="200">
    <p>Edit image</p>
    <form method="post" action="{{route('edit_admission_fees_ss',['id'=>$student->id])}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
        <div class="form-group">
            <input type="file" class="form-control" id="image" name='admission_fees_ss'>
            @if($errors->has('admission_fees_ss'))
            <div class="text-danger">{{$errors->first('admission_fees_ss')}}</div>
            @endif 
          </div>
        </div>
    </div>
                    
    <div class="text-center">
        <button type="submit" class="btn btn-lg btn-primary mt-3 text-center">Edit image</button>
      </div>
</form>


</div>
    @else

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header bg-primary text-center">
               <h3>Upload paid receipt screenshot {{$student->first_name}} {{$student->last_name}}</h3>
               <small>Visit the branch if you paid cash</small>
            </div>
            <div class="card-body">

              <form method="post" action="{{route('submit_admission_fees_ss',['id'=>$student->id] ) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="image">Upload Image</label>
                  <input type="file" class="form-control" id="image" name='admission_fees_ss'>
                </div>
                 @if($errors->has('admission_fees_ss'))
                <div class="text-danger">{{$errors->first('admission_fees_ss')}}</div>
                @endif 
        
                
          <div class="text-center">
         
                <button type="submit" class="btn btn-lg btn-primary mt-3 text-center">Upload image</button>
              </div>
              </form>
          
            </div>
          </div>
        </div>
      </div>


  

      @endif

    </div> 


 @section('scripts')

@if(Session::has('updated'))
<script>
    swal({
  title: "{{Session::get('updated')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 4000,
    });
</script> 
@endif

@endsection



@endsection