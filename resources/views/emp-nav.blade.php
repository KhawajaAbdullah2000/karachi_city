<nav class="navbar nav-home navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('logo.png')}}" class="kclogo" alt="Logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
            <a href="{{ route('emp_home') }}" class="nav-link">home</a>
        </li>
        @role('manager')
        <li class="nav-item">
            <a href="#" class="nav-link">Branch Details</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">Borrowed items</a>
        </li>
        @endrole
        <li class="nav-item">
            <a href="{{ route('logout')}}" class="nav-link">Logout</a>
        </li>

      </ul>
    </div>
  </nav>