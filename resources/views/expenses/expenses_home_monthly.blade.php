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
    @if($monthlyTotals->isEmpty())
<h1 class="text-center">No Expenses to show yet</h1>
    @else
    <div class="row">
    {{$monthlyTotals->links()}}
    </div>
    <table class="table table-hover">
      <thead>
          <tr>
            <th>Sno.</th>
            <th>Month</th>
            <th>Year</th>
            <th>Amount</th>
            
          </tr>
        </thead>
        <tbody>
          
          @foreach ($monthlyTotals as $monthlyTotals)
          <tr>
            
            <td>{{$loop->index+1}}</td>
            <td>{{$monthlyTotals->month}}</td>
            <td>{{$monthlyTotals->year}}</td>
            <td>{{$monthlyTotals->total_amount}}</td>
           
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