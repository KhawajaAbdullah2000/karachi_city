@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('admin_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">
    {{-- always include this nav2 first in div with id=content for admin pages --}}
    @include('admin_nav2')
    {{-- @if($message=Session::get('success'))
    <div class="alert alert-success alert-block">
        <strong>{{$message}}</strong>

    </div>

    @endif --}}
    

    <div class="invoice-items">
        <div class="table-responsive" style="overflow: hidden; outline: none;" tabindex="0">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="per70 text-center">Description</th>
                        <th class="per25 text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Revenune Generated from Monthly fees for the first quaterly</td>
                        @if($monthly_fees_revenue[0]->total_amount==0)
                        <td class="text-center">pkr 0.00</td>
                        @else
                        <td class="text-center">pkr {{ $monthly_fees_revenue[0]->total_amount }}.00</td>
                        @endif
                        
                    </tr>
                    <tr>
                        <td>Revenune Generated from Admission fees for the first quaterly</td>
                        @if($monthly_Afees_revenue[0]->total_Amount==0)
                        <td class="text-center">pkr 0.00</td>
                        @else
                        <td class="text-center">pkr {{$monthly_Afees_revenue[0]->total_Amount}}.00</td>
                        @endif
                        
                    </tr>
                    <tr>
                        <td>Expense incurred during these 4-month period</td>
                        @if($expense[0]->total_Amount==0)
                        <td class="text-center">pkr 0.00</td>
                        @else
                        <td class="text-center">pkr {{$expense[0]->total_Amount}}</td>
                        @endif
                    </tr>

                    <tr>
                        <td>Salary for the current 4-month period</td>
                        @if($salary[0]->total_amount==0)
                        <td class="text-center">pkr 0.00</td>
                        @else
                        <td class="text-center">pkr {{$salary[0]->total_amount}}</td>
                        @endif
                    </tr>
                    
                    <tr>
                        <td>PROFIT/LOSS</td>
                        
                        <td class="text-center">pkr {{$monthly_fees_revenue[0]->total_amount + $monthly_Afees_revenue[0]->total_Amount - ($expense[0]->total_Amount + $salary[0]->total_amount)}}</td>
                    </tr>
                </tbody>
               
            </table>
        </div>
    </div>

    @section('scripts')
 
@if(Session::has('success'))
<script>
    swal({
  title: "{{Session::get('success')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 4000,
    });
</script> 
@endif

@endsection


@endsection