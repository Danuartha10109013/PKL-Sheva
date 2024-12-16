<div class="sidenav-header">
  <i class="fas fa-times p-1 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
  <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank">
    <img src="{{asset('vendor/zen.png')}}" width="130px" class="navbar-brand-img h-100" style="margin-top: 10px;margin-bottom: -5px" alt="main_logo">
  </a>
</div>
<hr class="horizontal dark mt-0">
<div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
  <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('finance.finance') ? 'active' : '' }}" href="{{ route('finance.finance') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-tv-2 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
        </a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('finance.invoice') ? 'active' : '' }}" href="{{ route('finance.invoice') }}">

        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="ni ni-credit-card text-dark text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Kelola Invoice</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('finance.project') ? 'active' : '' }}" href="{{ route('finance.project') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-diagram-project text-dark text-sm opacity-10"></i>

          </div>
          <span class="nav-link-text ms-1">Project</span>
      </a>
  </li>
    
  </ul>
</div>
<div class="sidenav-footer mt-5 ">
  <div class="card card-plain shadow-none" id="sidenavCard">
    <img class="w-30 mx-auto" src="{{asset('zen-blue-logo.png')}}" alt="sidebar_illustration">
    <div class="card-body text-center p-3 w-100 pt-0">
      <div class="docs-info">
        <h6 class="mb-0">PT. Zen Multimedia</h6>
        <p class="text-xs font-weight-bold mb-0">Indonesia</p>
      </div>
    </div>
  </div>
</div>