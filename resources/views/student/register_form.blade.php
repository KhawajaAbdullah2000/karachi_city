@extends('master')

@section('content')

<div class="container center">
    <div class="form-width">
      <h2 class="text-center">Register</h2>
      <form method="post" action="">
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
          <input type="date" class="form-control" id="" name="DOB">
        </div>
        
        <div class="form-group mt-4 mb-4">
            <label for="gender">Gender</label>
            <select class="boxstyling" id="gender" name="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
          </div>

          <div class="form-group mt-2">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="" name='email' value="{{old('email')}}">
          </div>

          
          <div class="form-group mt-2">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="" name='password' value="{{old('email')}}">
          </div>

          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="" name='phone' value="{{old('phone')}}">
          </div>

          <div class="form-group">
            <label for="email">School</label>
            <input type="text" class="form-control" id="" name='school' value="{{old('school')}}">
          </div>







        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>

@endsection