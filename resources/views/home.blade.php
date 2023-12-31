@extends('master')

@section('content')

@section('class','cont')

{{-- @if(Session::has('status'))
<h3 class="text-secondary">{{Session::get('status')}}</h3>
@endif --}}


@include('home-nav')

<div class="text-center">

</div>


  <div class="homepage">

    <div class="homepage-content">

    {{-- <a href="{{route('register')}}" class="btn btn-warning btn-lg">Register Yourself</a> --}}
    </div>

  </div>


  @section('scripts')

        @if(Session::has('registered'))
              <script>
                  swal({
                title: "Kindly check your email for more details.",
                icon: "success",
                closeOnClickOutside: true,
                timer: 4000,
                  });
              </script>
      @endif


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
