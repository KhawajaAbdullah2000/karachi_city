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
               <h3>Update Details of Employee-ID {{$branches->id}}</h3> 
               <form method="POST" action="/Branches/{{$branches->id}}/update">
                   @csrf
                   @method('PUT')
                   <div class="form-group">
                    <label>Branch Name</label>
                    <input type="text" name="name" class="form-control" value="{{old('name', $branches->branch_name)}}" />
                    @if($errors->has('name'))
                       <span class="text-danger">{{$errors->first('name')}}</span>
                    @endif
                </div>
                
        
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="{{old('address', $branches->address)}}" />
                    @if($errors->has('address'))
                       <span class="text-danger">{{$errors->first('address')}}</span>
                    @endif
                </div>

                <div class="form-group mt-3 mb-3">
                    <select name="manager_id" id="manager_id" class="boxstyling bg-primary rounded">
                        @foreach($user as $u)
                            @if($u->role === 0)
                                <option value="{{$u->id}}">{{$u->name}}</option>    
                            @endif
                        @endforeach
                    </select> 
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