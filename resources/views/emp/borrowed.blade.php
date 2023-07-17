@extends('master')
@section('content')
@include('emp-nav')


<div class="container">
    @if($count==0)
    <h1 class="text-center">No Items Borrowed Yet</h1>
    @else
    <table class="table table-hover">
        <thead>
            <tr>
              <th>Item Name</th>
              <th>Borrowed by</th>
              <th>Date(YYYY-MM-DD)</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($borrowed as $borrow)
            <tr>
              <td>{{$borrow->item_name}}</td>
              <td>{{$borrow->name}}</td>
              <td>{{$borrow->created_at}}</td>
              <td>
                  <form method="POST" action="/emp_borrow/{{$borrow->id}}/delete" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Returned</button>
                  </form>
              </td>
            </tr>
            @endforeach 
          </tbody>
        </table>
    @endif
    <a href="/emp_items/{{auth()->user()->branch_id}}/borrow" class="btn btn-info btn-lg text-white">Borrow item</a>
</div>




<br>

@endsection