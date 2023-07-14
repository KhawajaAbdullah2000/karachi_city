@extends('master')

@section('content')
    
@include('home-nav')


<div class="container">

    <div class="row justify-content-center mt-4">
      <div class="col-sm-12 col-md-6">

        <div class="card">

          <div class="card-header bg-primary text-center">
            <h2>Student Login</h2>
          </div>

          <div class="card-body">
            <form method="post" action="{{route('student_login_logic')}}" class="mt-2">
              @csrf
                          <div class="form-group">
                              <label for="exampleInputEmail1">Email</label>
                              <input type="text" class="form-control" id="exampleInputEmail1"
                               aria-describedby="emailHelp" placeholder="" name='email' value="{{old('email')}}">
                            </div>
                            <div class="form-group">
                              <small><a href="{{route('student.password.request')}}" class="forgot-link">Forgot password</a></small>
                                </div>
                            @if($errors->has('email'))
                            <div class="text-danger">{{ $errors->first('email') }}</div>
                        @endif
                  
      
                          <div class="form-group mt-2">
                              <label for="exampleInputPassword1">Password</label>
                              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name='password'>
                            </div>
                    
                      @if($errors->has('password'))
                      <div class="text-danger">{{ $errors->first('password') }}</div>
                      @endif
                  
                  <div class="text-center">
           
                  <button type="submit" class="btn btn-primary btn-md mt-3">Login</button>
                </div>
                </form>

          </div>
        </div>

      </div>

    </div>

  </div>

  @section('scripts')
  @if(Session::has('error'))
  <script>
      swal({
    title: "{{Session::get('error')}}",
    icon: "error",
    closeOnClickOutside: true,
    timer: 3000,
      });
  </script> 
@endif

@endsection


@endsection

