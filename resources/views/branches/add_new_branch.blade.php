@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
    {{-- always include this nav2 first in div with id=content for admin pages --}}
    @include('admin_nav2')
    @if(session()->has('status'))
                 
    <div class="alert alert-success">
      {{session('status')}}
    </div>
    @endif    
    <div class="row justify-content-center">
        <div class="col-sm-8">
           <div class="card mt-3 p-3 bg-primary text-white">
               <form method="POST" action="/Branches/store" >
                   @csrf
                   @method('POST')
                   <div class="form-group">
                    <label>Branch Name</label>
                    <input type="text" name="name" class="form-control" value="{{old('name')}}" />
                    @if($errors->has('name'))
                       <span class="text-danger">{{$errors->first('name')}}</span>
                    @endif
                </div>
                
        
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="{{old('address')}}" />
                    @if($errors->has('address'))
                       <span class="text-danger">{{$errors->first('address')}}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-dark mt-3">Submit</button>
               </form>
               
           </div>    
        </div>
   </div>

<br>


</div> 

</div> 


@endsection