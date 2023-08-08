@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
    {{-- always include this nav2 first in div with id=content for admin pages --}}
    @include('admin_nav2')
    <div class="row justify-content-center">
        <div class="col-sm-8">
           <div class="card mt-3 p-3 bg-primary text-white">
               <form method="POST" action="/zktecoDevice/store" enctype="multipart/form-data">
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
                
                <div class="form-group mt-3 mb-3">
                    <select name="branch_id" id="branch_id" class="boxstyling bg-primary rounded">
                        @foreach($branches as $b)
                        <option value="{{$b->id}}">{{$b->branch_name}}</option>
                        @endforeach
                      </select> 
                </div>

                <button type="submit" class="btn btn-dark mt-3">Submit</button>

                </form>
            </div>    
         </div>
    </div>
 


</div> 


@endsection        