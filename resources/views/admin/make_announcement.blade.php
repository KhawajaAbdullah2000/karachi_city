@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
    {{-- always include this nav2 first in div with id=content for admin pages --}}
    @include('admin_nav2')

    <div class="container">
   
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header bg-primary text-center">
                   <h2>Create a new announcement</h2>
                </div>
                <div class="card-body">
                  <form method="post" action="{{route('create_announcement')}}">
                    @csrf
                    <div class="form-group">
                      <label for="name">Title</label>
                      <input type="text" class="form-control" id="name" name='title' value="{{old('title')}}">
                    </div>
                    @if($errors->has('title'))
                    <div class="text-danger">{{$errors->first('title')}}</div>
                    @endif
              
                      <div class="form-group">
                        <label for="description">Description</label>
                     <textarea name="description" class="form-control" cols="30" rows="10">{{old('description')}}</textarea>
                     @if($errors->has('description'))
                     <div class="text-danger">{{$errors->first('description')}}</div>
                     @endif
            
                    
              <div class="text-center">
             
                    <button type="submit" class="btn btn-lg btn-primary mt-2 text-center">Make announcement</button>
                  </div>
                  </form>
              
                </div>
              </div>
            </div>
          </div>

    </form>
</div>





</div> 

</div> 


@endsection