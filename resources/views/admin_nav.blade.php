
<nav id="sidebar">
    <div class="p-4 pt-5">
      <a href="#" class="img logo rounded-circle mb-5" style=""></a>
<ul class="list-unstyled components mb-5">
  <li class="active">
    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
    <ul class="collapse list-unstyled" id="homeSubmenu">
    <li>
        <a href="/admin_home">Home</a>
    </li>
    <li>
        <a href="#">Home 2</a>
    </li>
    <li>
        <a href="#">Home 3</a>
    </li>
    </ul>
  </li>
  <li>
      <a href="/employees">Employees</a>
  </li>
  <li>
    <a href="/Branches">Branches</a>
</li>
<li>
  <a href="/zktecoDevices">Biometric Devices</a>
</li>

<li class="nav-item">
  <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Announcements</a>
  <ul class="collapse navbar-nav list-unstyled" id="pageSubmenu">
    <li class="nav-item">
        <a href="{{route('make_announcement')}}">Make Announcement</a>
    </li>
    <li class="nav-item">
        <a href="{{route('announcements')}}">Announcements</a>
    </li>
  </ul>
  </li>

</ul>


</div>
</nav>


