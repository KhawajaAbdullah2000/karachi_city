	
	@auth('student')
    <nav class="navbar navbar-expand-lg navbar-light mynavbar">
        <a class="navbar-brand" href="#"><img src="{{asset('logo.png')}}" alt="karachi city" class=kclogo></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-md-inline-flex" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto topnav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('student_home')}}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Shop Pre-Owned</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Shop New Cars</a>
                </li>
              
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{auth('student')->user()->first_name}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">My Profile</a>
                        <a href='{{route('student_edit_form',['id'=>auth('student')->user()->id])}}' class="dropdown-item">Edit Profile</a>

                       
                    </div>
                </li>
                 <li class="nav-item">
                    <a href="{{ url('/student_logout') }}" class="nav-link bg-primary rounded">Log out</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>  --}}
           
            </ul>
        </div>

            <!-- The Modal -->
            

      
            </div>
        </div>
    </div>
            

    </nav>

    @endauth