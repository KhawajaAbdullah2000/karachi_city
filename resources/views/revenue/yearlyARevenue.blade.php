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
    @if($yearlyfees->isEmpty())
<h1 class="text-center">No Expenses to show yet</h1>
    @else
    <div class="row">
    {{$yearlyfees->links()}}
    </div>
    <table class="table table-hover">
      <thead>
          <tr>
            <th>Sno.</th>
            <th>Year</th>
            <th>Total Amount</th>
            
          </tr>
        </thead>
        <tbody>
          
          @foreach ($yearlyfees as $yearlyfees)
          <tr>
            
            <td>{{$loop->index+1}}</td>
            <td>{{$yearlyfees->year}}</td>
            <td>PKR {{$yearlyfees->total_amount}}</td>
            
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