@extends('master')
@section('content')
@include('emp-nav')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8">
           <div class="card mt-3 p-3 bg-primary text-white">
               <form method="POST" action="/zktecoDevice/{{auth()->user()->branch_id}}/store" enctype="multipart/form-data">
                   @csrf
                   <div class="form-group">
                    <label>IP</label>
                    <input type="text" name="ip" class="form-control" value="{{old('ip')}}" />
                    @if($errors->has('ip'))
                       <span class="text-danger">{{$errors->first('ip')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Model Name</label>
                    <input type="text" name="model_name" class="form-control" value="{{old('model_name')}}" />
                    @if($errors->has('model_name'))
                       <span class="text-danger">{{$errors->first('model_name')}}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-dark mt-3">Submit</button>

                </form>
            </div>    
         </div>
    </div>
 


</div> 


@endsection        