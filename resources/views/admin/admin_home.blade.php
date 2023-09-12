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
<h1>Welcome Admin  {{auth()->user()->name}}</h1>


<br> <br> 
                <div class="container">
                  <div class="row">
                    <div class="col">
                      <div class="card text-white bg-primary mb-3" style="max-width: 15rem;">
                      <div class="card" style="width: 15rem;">
                          <div class="card-body">
                            <h5 class="card-title"><h3>FIRST QUATERLY</h3>
                            <p class="card-text">CHECK THE FINANCIAL POSTION OF THE STARTING FOUR MONTHS OF THE CURRENT FISCAL YEAR.</p>
                            <a href="/q1" class="btn btn-warning">Q1</a>
                          </div>
                        </div>
                    </div>
                  </div>
                    
                    <div class="col"><div class="card text-white bg-primary mb-3" style="max-width: 15rem;">
                      <div class="card" style="width: 15rem;">
                          <div class="card-body">
                            <h5 class="card-title"><h3>SECOND QUATERLY</h3>
                            <p class="card-text">CHECK THE FINANCIAL POSTION OF THE NEXT FOUR MONTHS OF THE CURRENT FISCAL YEAR.</p>
                            <a href="/q2" class="btn btn-danger">Q2</a>
                          </div>
                        </div>
                    </div>
                  </div>
                    
                  <div class="col">
                    <div class="card text-white bg-primary mb-3" style="max-width: 15rem;">
                      <div class="card" style="width: 15rem;">
                          <div class="card-body">
                            <h5 class="card-title"><h3>THIRD QUATERLY</h3>
                            <p class="card-text">CHECK THE FINANCIAL POSTION OF THE LAST FOUR MONTHS OF THE CURRENT FISCAL YEAR.</p>
                            <a href="/q3" class="btn btn-primary">Q3</a>
                          </div>
                        </div>
                    </div>
                  </div>

                    <div class="col">
                      <div class="card text-white bg-primary mb-3" style="max-width: 15rem;">
                      <div class="card" style="width: 15rem;">
                          <div class="card-body">
                            <h5 class="card-title"><h3>YEARLY POSITION</h3>
                            <p class="card-text">CHECK THE FINANCIAL POSTION OF THE CURRENT FISCAL YEAR.</p>
                            <a href="/Y" class="btn btn-dark">YEARLY</a>
                          </div>
                        </div>
                    </div>
                  </div>

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