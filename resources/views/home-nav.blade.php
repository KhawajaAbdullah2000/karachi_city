<nav class="navbar nav-home navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('logo.png')}}" class="kclogo" alt="Logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
            <a href="{{route('login_form')}}" class="nav-link">Employee Login</a>
        </li>
        <li class="nav-item">
            <a href="{{route('student_login')}}" class="nav-link">Student Login</a>
        </li>

      </ul>
    </div>
  </nav>