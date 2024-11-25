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
        <a class="nav-link {{ request()->routeIs('pm.PM') ? 'active' : '' }}" href="{{ route('pm.PM') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-tv-2 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pm.k-user') ? 'active' : '' }}" href="{{ route('pm.k-user') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Kelola User</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pm.k-project') ? 'active' : '' }}" href="{{ route('pm.k-project') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-app text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Kelola Project</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pm.k-forum') ? 'active' : '' }}" href="{{ route('pm.k-forum') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-app text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Forum Diskusi</span>
        </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="{{asset('vendorin')}}/pages/billing.html">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="ni ni-credit-card text-dark text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Billing</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="{{asset('vendorin')}}/pages/virtual-reality.html">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="ni ni-app text-dark text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Virtual Reality</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="{{asset('vendorin')}}/pages/rtl.html">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="ni ni-world-2 text-dark text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">RTL</span>
      </a>
    </li>
    <li class="nav-item mt-3">
      <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="{{asset('vendorin')}}/pages/profile.html">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Profile</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="{{asset('vendorin')}}/pages/sign-in.html">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="ni ni-single-copy-04 text-dark text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Sign In</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="{{asset('vendorin')}}/pages/sign-up.html">
        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
          <i class="ni ni-collection text-dark text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Sign Up</span>
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