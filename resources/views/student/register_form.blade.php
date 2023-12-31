@extends('master')

@section('content')

@include('home-nav')

<div class="container">





<div class="row justify-content-center mt-4">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-primary text-center">
         <h2>Register yourself</h2>
      </div>
      @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
      <div class="card-body">
        <form method="post" action="{{route('student_register')}}">
          @csrf
          <div class="form-group">
            <label for="name">First name:</label>
            <input type="text" class="form-control" id="name" name='first_name' value="{{old('first_name')}}">
          </div>
    
            <div class="form-group">
              <label for="lname">Last name:</label>
              <input type="text" class="form-control" id="" name='last_name' value="{{old('last_name')}}">
            </div>
    
          <div class="form-group">
            <label for="dob">Date of birth</label>
            <input type="date" class="form-control" id="" name="DOB" value={{old('DOB')}}>
          </div>
          
          <div class="form-group mt-4 mb-4">
              <label for="gender">Gender</label>
              <select class="boxstyling bg-primary rounded" id="gender" name="gender">
                  <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                  <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
              </select>
            </div>
    
            <div class="form-group mt-2">
              <label for="email">Email</label>
              <input type="text" class="form-control" id="" name='email' value="{{old('email')}}">
            </div>
    
            
            <div class="form-group mt-2">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="" name='password'>
            </div>

            <div class="form-group mt-2">
              <label for="password">Confirm Password</label>
              <input type="password" class="form-control" id="" name='passconfirm'>
            </div>
    
    
            <div class="form-group mt-3 mb-3">
              <label for="branch">Branch</label>
              <select name="branch_id" id="branch_id" class="boxstyling bg-primary rounded">
                  @foreach($branches as $b)
                  <option value="{{$b->id}}" {{ old('branch_id') == $b->id ? 'selected' : '' }}>{{$b->branch_name}}</option>
                  @endforeach
                </select> 
          </div>
    
            <div class="form-group">
              <label for="phone">Phone</label>
              <input type="text" class="form-control" id="" name='phone' value="{{old('phone')}}">
            </div>
    
            <div class="form-group">
              <label for="email">School</label>
              <input type="text" class="form-control" id="" name='school' value="{{old('school')}}">
            </div>
    
            <div class="form-group">
              <label for="email">Medical</label>
              <input type="text" class="form-control" id="" name='medical' value="{{old('medical')}}">
            </div>
    
            <div class="form-group">
              <label for="email">Parent's email</label>
              <input type="text" class="form-control" id="" name='parent_email' value="{{old('parent_email')}}">
            </div>
    
            <div class="form-group">
              <label for="email">Parent phone</label>
              <input type="text" class="form-control" id="" name='parent_phone' value="{{old('parent_phone')}}">
            </div>
    
            
            <div class="form-group">
              <label for="email">Emergency contact name</label>
              <input type="text" class="form-control" id="" name='emergency_name' value="{{old('emergency_name')}}">
            </div>
    
            
            <div class="form-group">
              <label for="email">Emergency contact no.</label>
              <input type="text" class="form-control" id="" name='emergency_contact' value="{{old('emergency_contact')}}">
            </div>
    <div class="text-center">
   
          <button type="submit" class="btn btn-lg btn-primary mt-2 text-center">Register</button>
        </div>
        </form>
    
      </div>
    </div>
  </div>
</div>

</div>

@endsection