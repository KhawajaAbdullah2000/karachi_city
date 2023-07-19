@extends('master')

@section('content')

@include('student.student_nav')

<div class="container">

@if(isset($fee_details))

<div class="text-center">


<h2>Already uploaded for this month</h2>
<img src="/monthly_fees/{{$fee_details->monthly_fees_ss}}" alt="" width="300px" height="300px">
@if($fee_details->paid==0)
<p>Edit image</p>
<form method="post" action="{{route('edit_monthly_fees',['id'=>$fee_details->student_id])}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-12">
    <div class="form-group">
        <input type="file" class="form-control" id="image" name='monthly_fees_ss'>
       @if($errors->has('monthly_fees_ss'))
        <div class="text-danger">{{$errors->first('monthly_fees_ss')}}</div>
        @endif  
      </div>
    </div>
</div>

</div>
      
<div class="text-center">
    <button type="submit" class="btn btn-lg btn-primary mt-3 text-center">Edit image</button>
  </div>
</form>


@endif

@else 


    <h2 class="text-center">Upload paid fee receipt for the month {{$month}} {{$year}}</h2>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header bg-primary text-center">
               <h3>Upload paid receipt screenshot for this month {{auth('student')->user()->first_name}}</h3>
               <small>Visit the branch if you paid cash</small>
            </div>
            <div class="card-body">

              <form method="post" action="{{route('submit_monthly_fees_ss',['id'=>auth('student')->user()->id] ) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="image">Upload Image</label>
                  <input type="file" class="form-control" id="image" name='monthly_fees_ss'>
                </div>
                  @if($errors->has('monthly_fees_ss'))
                <div class="text-danger">{{$errors->first('monthly_fees_ss')}}</div>
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