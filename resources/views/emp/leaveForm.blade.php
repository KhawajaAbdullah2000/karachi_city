@extends('master')
@section('content')
@include('emp-nav')


<div class="row justify-content-center">
    <div class="col-sm-8">
       <div class="card mt-3 p-3 bg-primary text-white">
           <form method="POST" action="/emp_home/{{auth()->user()->id}}/store" enctype="multipart/form-data">
               @csrf
               <div class="form-group">
                <label>Reason</label>
                <input type="text" name="reason" class="form-control" value="{{old('reason')}}" />
                @if($errors->has('reason'))
                   <span class="text-danger">{{$errors->first('reason')}}</span>
                @endif
                </div>
                <div class="form-group">
                    <label>Details</label>
                    <textarea type="text" name="details" rows="4" class="form-control">{{old('details')}}</textarea>
                    @if($errors->has('details'))
                       <span class="text-danger">{{$errors->first('details')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="from_date">From Date</label>
                    <input type="date" class="form-control" id="" name="from_date" value={{old('from_date')}}>
                </div>
                <div class="form-group">
                    <label for="to_date">To Date</label>
                    <input type="date" class="form-control" id="" name="to_date" value={{old('to_date')}}>
                </div>
                  
               <button type="submit" class="btn btn-dark mt-3">Submit</button>
           </form>
       </div>    
    </div>
</div>









<br>

@endsection