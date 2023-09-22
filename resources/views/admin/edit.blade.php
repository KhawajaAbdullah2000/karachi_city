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
               <h3>Update Details of Employee-ID {{$user->id}}</h3> 
               <form method="POST" action="/employees/{{$user->id}}/edit" enctype="multipart/form-data">
                   @csrf
                   @method('PUT')
                   <div class="form-group">
                       <label>Name</label>
                       <input type="text" name="name" class="form-control" value="{{old('name', $user->name)}}" />
                       @if($errors->has('name'))
                          <span class="text-danger">{{$errors->first('name')}}</span>
                       @endif
                   </div>
                   <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="{{old('email',$user->email)}}" />
                    @if($errors->has('email'))
                       <span class="text-danger">{{$errors->first('email')}}</span>
                    @endif
                </div>                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" value="{{old('password')}}" />
                    @if($errors->has('password'))
                       <span class="text-danger">{{$errors->first('password')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Mobile No.</label>
                    <input type="text" name="number" class="form-control" value="{{old('number',$user->phone)}}" />
                    @if($errors->has('number'))
                       <span class="text-danger">{{$errors->first('number')}}</span>
                    @endif
                </div>

                <div class="form-group mt-3 mb-3">
                    <label>Branch</label>
                    <select name="branch_id" id="branch_id" class="form-control boxstyling bg-info rounded">
                        @foreach($branches as $b)
         <option value="{{$b->id}}" {{ old('branch_id',$user->branch_id) == $b->id ? 'selected' : '' }}>{{$b->branch_name}}</option>

                        {{-- <option value="{{$b->id}}">{{$b->branch_name}}</option> --}}
                        @endforeach
                      </select> 
                </div>

        

                <div class="form-group">
                    <label>CNIC No.</label>
                    <input type="text" name="cnic" class="form-control" value="{{old('cnic',$user->cnic)}}" />
                    @if($errors->has('cnic'))
                       <span class="text-danger">{{$errors->first('cnic')}}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label>Salary</label>
                    <input type="text" name="salary" class="form-control" value="{{old('salary',$user->salary)}}" />
                    @if($errors->has('salary'))
                       <span class="text-danger">{{$errors->first('salary')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label>CNIC Front</label>
                    <input type="file" name="front" class="form-control"/>
                    @if($errors->has('front'))
                       <span class="text-danger">{{$errors->first('front')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label>CNIC Back</label>
                    <input type="file" name="back" class="form-control"/>
                    @if($errors->has('back'))
                       <span class="text-danger">{{$errors->first('back')}}</span>
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