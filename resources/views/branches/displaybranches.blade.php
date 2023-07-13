@extends('master')

@section('content')
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{url('Branches/delete')}}" method="POST">
            @csrf
            @method('Delete')
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Branch Delete</h1>
          <a href="/Branches">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
          </a>

        </div>
        
        <div class="modal-body">
            <input type="hidden" name="category_delete_id" id="category_id"/>
          <h5>Are you sure you want to permenantly delete this branch's data?</h5>
        </div>
        <div class="modal-footer">
          
          <button type="submit" class="btn btn-danger">Yes Delete</button>
        </div>
        </form>
        
      </div>
    </div>
  </div>

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
    {{-- always include this nav2 first in div with id=content for admin pages --}}
    @include('admin_nav2')
    
    
    <h1 style="color: #3c3737;">Branch Page</h1>


<table class="table table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>BRANCH NAME</th>
        <th>ADDRESS</th>
        <th>Manager-ID</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($branches as $branches)
      
      <tr>
        <td>{{$branches->id}}</td>
        <td>{{$branches->branch_name}}</td>
        <td>{{$branches->address}}</td>
        <td>{{$branches->manager_id}}</td>
        
        <td>
            <a href="#" class="btn btn-dark btn-sm">Edit</a> 
            <button type="button" class="btn btn-danger btn-sm deleteCategoryBtn" value="{{$branches->id}}">Delete</button>
            
        </td>
      </tr>
      
      @endforeach 
    </tbody>
  </table>

<br>

<a href="/Branches/create" class="btn btn-info btn-sm text-white" role="button">Add New Branch</a>
</div> 
</div> 


@endsection

@section('scripts')
<script>
    $(document).ready(function(){
     //$('.deleteCategoryBtn').click(function (e){
        $(document).on('click','.deleteCategoryBtn',function (e){
       e.preventDefault();
      var category_id= $(this).val();
      $('#category_id').val(category_id)
      $('#deleteModal').modal('show');
     });

    });
    </script>
@endsection

