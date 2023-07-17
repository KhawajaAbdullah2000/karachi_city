@extends('master')
@section('content')
@include('emp-nav')
@if(Session::has('error'))
<h2 class="text-danger">{{Session::get('error')}}</h2>
@endif

<div class="container">
    @if($items->count()==0)
<h1 class="text-center">No Items Added Yet</h1>
    @else
    <table class="table table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($items as $item)
          <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->item_name}}</td>
            <td>
                <a href="/emp_items/{{$item->id}}/update" class="btn btn-dark btn-sm">Edit</a>
                <form method="POST" action="/emp_items/{{$item->id}}/delete" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
          </tr>
          @endforeach 
        </tbody>
      </table>
      @endif
    <a href="/emp_items/{{auth()->user()->branch_id}}/add" class="btn btn-info btn-lg text-white">Add new item</a>
    
</div>

@endsection