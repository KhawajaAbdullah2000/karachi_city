@extends('master')

@section('content')

<div class="ml-4">


   
    @if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <p class="text-bold">{{Session::get('error')}}
      <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"></span>
      </button>
    </div>
        
    @endif
    
    
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <p class="text-bold">{{Session::get('success')}}
      <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"></span>
      </button>
    </div>
        
    @endif
    
   
    <form method="post" action="/login" class="mt-2 mx-3">
        @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone</label>
                        <input type="text" class="form-control" id="exampleInputEmail1"
                         aria-describedby="emailHelp" placeholder="03xxxxxxxxx" name='phone' value="{{old('phone')}}">
                      </div>
                      @if($errors->has('phone'))
                      <div class="text-danger">{{ $errors->first('phone') }}</div>
                  @endif
                </div>
            </div>
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name='password'>
                      </div>
                </div>
                @if($errors->has('password'))
                <div class="text-danger">{{ $errors->first('password') }}</div>
            @endif
            </div>
          
           
     
            <button type="submit" class="btn btn-primary mt-3">Login</button>
          </form>
       

        </div>

@endsection