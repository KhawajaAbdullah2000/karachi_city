@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
    {{-- always include this nav2 first in div with id=content for admin pages --}}
    @include('admin_nav2')

    <div style="margin: 10vh auto; padding: 20px; text-align: center;">
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                <h2 style="color: #33361C;">BRANCH FINANCES AND INVENTORY</h2>
            </a>
            <a href="/expenses_home_monthly/{{$id}}" class="list-group-item list-group-item-action">Monthly Expenditure</a>
            <a href="/expenses_home_yearly/{{$id}}" class="list-group-item list-group-item-action">Yearly Expenditure</a>
            <a href="/monthlyRevenue/{{$id}}" class="list-group-item list-group-item-action">Monthly fees Revenue</a>
            <a href="/yearlyRevenue/{{$id}}" class="list-group-item list-group-item-action">Yearly fees Revenue</a>
            <a href="/monthlyAdmissionRevenue/{{$id}}" class="list-group-item list-group-item-action">Monthly Admission fees Revenue</a>
            <a href="/yearlyAdmissionRevenue/{{$id}}" class="list-group-item list-group-item-action">Yearly Admission fees Revenue</a>
            
          </div>
        
    </div>
      
      
</div> 
</div> 

@endsection