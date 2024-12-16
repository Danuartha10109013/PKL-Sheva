<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">@yield('pages')</li>
      </ol>
      <h6 class="font-weight-bolder text-white mb-0">@yield('pages')</h6>
    </nav>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        
      </div>
      <ul class="navbar-nav  justify-content-end">
        <li class="nav-item dropdown d-flex align-items-center">
          <a href="#" class="nav-link text-white font-weight-bold px-0 dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('storage/user_profile/'.Auth::user()->id.'/'.Auth::user()->profile) }}" alt="Profile" style="border-radius: 9px; border: 2px solid white;" class="avatar avatar-sm rounded-circle me-2">
            <span class="d-sm-inline d-none">{{Auth::user()->username}}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="{{ route('profile',Auth::user()->id) }}">Edit Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
          </ul>
        </li>
        
        
        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
            </div>
          </a>
        </li>
        <li class="nav-item px-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white p-0">
            <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
          </a>
        </li>
        
      </ul>
    </div>
  </div>
</nav>