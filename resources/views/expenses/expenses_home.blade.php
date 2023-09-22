
@extends('master')
@section('content')
@include('emp-nav')

@if(session()->has('status'))
                 
    <div class="alert alert-success">
      {{session('status')}}
    </div>
 @endif  

<div class="wrapper d-flex align-items-stretch">
<div class="container">
  @if($expenses->isEmpty())
<h1 class="text-center">No Expenses Added Yet</h1>
    @else
    <div class="row">
    {{$expenses->links()}}
    </div>
    <table class="table table-hover">
      <thead>
          <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Date&Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          
          @foreach ($expenses as $expenses)
          <tr>
            
            <td>{{$loop->index+1}}</td>
            <td>{{$expenses->Category}}</td>
            <td>PKR {{number_format($expenses->Amount, 2)}}</td>
            <td>{{$expenses->created_at}}</td>
            <td>
                <a href="/expenses_home/{{$expenses->id}}/{{$expenses->branch_id}}/edit" class="btn btn-dark btn-sm">Edit</a>
                <button type="button" class="btn btn-danger btn-sm deleteCategoryBtn" value="{{$expenses->id}}">Delete</button>
            </td>
          </tr>
         @endforeach
    
      </table>
      
      @if(Session::has('error'))
      <p class="text-danger">{{Session::get('error')}}</p>
       @endif 
    
      @endif
    <a href="/expenses_home/{{auth()->user()->branch_id}}/add" class="btn btn-info btn-lg text-white">Add a new expense</a>
    
</div>
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/expenses_home/delete" method="POST">
          @csrf
          @method('Delete')
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Branch Delete</h1>
        <a href="/expenses_home/{{auth()->user()->branch_id}}">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
        </a>

      </div>
      
      <div class="modal-body">
          <input type="hidden" name="category_delete_id" id="category_id"/>
        <h5>Are you sure you want to permenantly delete this record?</h5>
      </div>
      <div class="modal-footer">
        
        <button type="submit" class="btn btn-danger">Yes Delete</button>
      </div>
      </form>
      
    </div>
  </div>
</div>

@section('scripts')
<script>
    $(document).ready(function(){
     
        $(document).on('click','.deleteCategoryBtn',function (e){
       e.preventDefault();
      var category_id= $(this).val();
      $('#category_id').val(category_id)
      $('#deleteModal').modal('show');
     });

    });
    </script>
@endsection
@endsection