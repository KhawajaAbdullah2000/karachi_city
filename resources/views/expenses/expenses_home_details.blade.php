@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
  {{-- always include this nav2 first in div with id=content for admin pages --}}
  @include('admin_nav2')
<div class="wrapper d-flex align-items-stretch">

<div class="container">
    @if($monthlydetails->isEmpty())
<h1 class="text-center">No Expenses to show yet</h1>
    @else
    <div class="row">
    {{$monthlydetails->links()}}
    </div>
    <table class="table table-hover">
      <thead>
          <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Date&Time</th>
          </tr>
        </thead>
        <tbody>
          
          @foreach ($monthlydetails as $monthlydetails)
          <tr>
            <td>{{$loop->index+1}}</td>
            <td>{{$monthlydetails->Category}}</td>
            <td>PKR {{number_format($monthlydetails->Amount, 2)}}</td>
            <td>{{$monthlydetails->created_at}}</td>
          </tr>
         @endforeach
    
      </table>
      
      @if(Session::has('error'))
      <p class="text-danger">{{Session::get('error')}}</p>
       @endif 
    
      @endif
    
    
</div>


</div>
</div>
@endsection