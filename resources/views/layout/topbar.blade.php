<!-- Make sure Font Awesome is loaded -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">
    
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm">
          <a class="opacity-5 text-white" href="javascript:;">Pages</a>
        </li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">@yield('pages')</li>
      </ol>
      <h6 class="font-weight-bolder text-white mb-0">@yield('pages')</h6>
    </nav>

    <!-- Navbar Right Side -->
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <ul class="navbar-nav ms-auto justify-content-end align-items-center">

        <!-- Notification Bell for Role 3 -->
        @php
            $role = Auth::user()->role;
        @endphp

        @if ($role == 3)
            @php
                $notif = \App\Models\NotifM::where('hapus', 0)->where('user_id', Auth::id())
                            ->orderBy('created_at','desc')
                            ->where('invoice_id',null)
                            ->get();
                $baru = $notif->where('status', 0)->count();
            @endphp
        @elseif ($role == 2)
            @php
                $notif = \App\Models\NotifM::where('hapus_finance',0)->whereNotNull('invoice_id')
                            ->orderBy('created_at','desc')
                            ->get();
                $baru = $notif->where('status_finance', 0)->count();
            @endphp
        @elseif ($role == 0)
            @php
              $notif = \App\Models\NotifKlienM::where('hapus',0)->where('status','!=',2)->orderBy('created_at','desc')->get();
              $baru = $notif->where('status',0)->count();
            @endphp
        @elseif ($role == 1)
            @php

              $allNotif = \App\Models\NotifKlienM::where('hapus_tl',0)->orderBy('created_at', 'desc')->get();

              $notif = $allNotif->filter(function ($n) {
                  $user = \App\Models\User::find($n->user_id);
                  return $user && $user->role != 1;
              });
              $baru = $notif->where('status_tl',0)->count();
            @endphp
        @endif

        @if ($role == 3 || $role == 2)
          <li class="nav-item dropdown" style="margin-right: 1em">
              <a class="nav-link dropdown-toggle position-relative text-white" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-bell"></i>
                  @if ($baru > 0)
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                          {{ $baru }}
                          <span class="visually-hidden">unread messages</span>
                      </span>
                  @endif
              </a>

              <ul class="dropdown-menu dropdown-menu-end p-2" style="width: 320px;" aria-labelledby="notifDropdown">
                  <form action="{{ $role == 3 ? route('klien.notif.readselected') : route('finance.notif.readselected') }}" method="POST" id="notifForm">
                      @csrf
                      <li class="d-flex gap-2">
                          <button type="submit" class="btn btn-sm btn-primary w-100 mb-2" id="btn-read" disabled>Tandai Telah Dibaca</button>
                          <button formaction="{{ $role == 3 ? route('klien.notif.deleteselected') : route('finance.notif.deleteselected') }}" type="submit" class="btn btn-sm btn-danger w-100 mb-2" id="btn-delete" disabled>Hapus</button>
                      </li>
                      <li><hr class="dropdown-divider"></li>

                      @forelse ($notif as $n)
                          @php
                              $readClass = $role == 3 
                                ? ($n->status == 1 ? 'text-muted opacity-75' : 'fw-bold') 
                                : ($n->status_finance == 1 ? 'text-muted opacity-75' : 'fw-bold');
                              $link = $role == 3
                                  ? route('klien.project', $n->project_id)
                                  : route('finance.invoice', ['id' => $n->invoice_id]);
                          @endphp
                          <li class="form-check mb-2">
                              <input class="form-check-input notif-checkbox-main" type="checkbox" name="notif_ids[]" value="{{ $n->id }}" id="notif{{ $n->id }}">
                              <label class="form-check-label w-100" for="notif{{ $n->id }}">
                                  <a href="{{ $link }}" class="text-decoration-none d-block {{ $readClass }}">
                                      <div>{{ $n->title }}</div>
                                      <small>{{ $n->value }}</small>
                                  </a>
                              </label>
                          </li>
                      @empty
                          <li class="dropdown-item text-muted">Tidak ada notifikasi</li>
                      @endforelse
                  </form>
              </ul>
          </li>
            <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkboxes = document.querySelectorAll('.notif-checkbox-main');
                const btnRead = document.getElementById('btn-read');
                const btnDelete = document.getElementById('btn-delete');

                function toggleButtons() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    btnRead.disabled = !anyChecked;
                    btnDelete.disabled = !anyChecked;
                }

                checkboxes.forEach(cb => cb.addEventListener('change', toggleButtons));
                toggleButtons();
            });
            </script>

        @elseif($role == 0)
           <li class="nav-item dropdown" style="margin-right: 1em">
              <a class="nav-link dropdown-toggle position-relative text-white" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-bell"></i>
                  @if ($baru > 0)
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                          {{ $baru }}
                          <span class="visually-hidden">unread messages</span>
                      </span>
                  @endif
              </a>

              <ul class="dropdown-menu dropdown-menu-end p-2" style="width: 320px;" aria-labelledby="notifDropdown">
                  <form method="POST" id="notifForm">
                      @csrf
                      <li class="d-flex justify-content-between mb-2">
                          <button type="submit" id="markReadBtn-pm" formaction="{{ route('pm.notif.readselected') }}" class="btn btn-sm btn-primary w-50 me-1" disabled>
                              Tandai Dibaca
                          </button>
                          <button type="submit" id="deleteBtn-pm" formaction="{{ route('pm.notif.deleteselected') }}" class="btn btn-sm btn-danger w-50 ms-1" disabled
                                  onclick="return confirm('Yakin ingin menghapus notifikasi terpilih?')">
                              Hapus
                          </button>
                      </li>
                      <li><hr class="dropdown-divider"></li>

                      @forelse ($notif as $n)
                          @php
                              $readClass = $n->status == 1 ? 'text-muted opacity-75' : 'fw-bold';
                              $link = $role == 3
                                  ? route('klien.project', $n->project_id)
                                  : route('finance.invoice', ['id' => $n->invoice_id]);
                          @endphp
                          <li class="form-check mb-2">
                              <input class="form-check-input notif-checkbox-pm" type="checkbox" name="notif_ids[]" value="{{ $n->id }}" id="notif{{ $n->id }}">
                              <label class="form-check-label w-100" for="notif{{ $n->id }}">
                                  <a href="{{ route('pm.k-project.communication', $n->project_id) }}" class="text-decoration-none d-block {{ $readClass }}">
                                      <div>{{ $n->title }}</div>
                                      <small>{{ $n->value }}</small>
                                  </a>
                              </label>
                          </li>
                      @empty
                          <li class="dropdown-item text-muted">Tidak ada notifikasi</li>
                      @endforelse
                  </form>
              </ul>
          </li>

          <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkboxes = document.querySelectorAll('.notif-checkbox-pm');
                const markReadBtn = document.getElementById('markReadBtn-pm');
                const deleteBtn = document.getElementById('deleteBtn-pm');

                function toggleButtons() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    markReadBtn.disabled = !anyChecked;
                    deleteBtn.disabled = !anyChecked;
                }

                checkboxes.forEach(cb => cb.addEventListener('change', toggleButtons));
                toggleButtons();
            });
            </script>
        @elseif($role == 1)
           <li class="nav-item dropdown" style="margin-right: 1em">
              <a class="nav-link dropdown-toggle position-relative text-white" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-bell"></i>
                  @if ($baru > 0)
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                          {{ $baru }}
                          <span class="visually-hidden">unread messages</span>
                      </span>
                  @endif
              </a>

              <ul class="dropdown-menu dropdown-menu-end p-2" style="width: 320px;" aria-labelledby="notifDropdown">
                  <form method="POST" id="notifForm">
                      @csrf
                      <li class="d-flex justify-content-between mb-2">
                          <button type="submit" id="markReadBtn-tl" formaction="{{ route('team_lead.notif.readselected') }}" class="btn btn-sm btn-primary w-50 me-1" disabled>
                              Tandai Dibaca
                          </button>
                          <button type="submit" id="deleteBtn-tl" formaction="{{ route('team_lead.notif.deleteselected') }}" class="btn btn-sm btn-danger w-50 ms-1" disabled
                                  onclick="return confirm('Yakin ingin menghapus notifikasi terpilih?')">
                              Hapus
                          </button>
                      </li>
                      <li><hr class="dropdown-divider"></li>

                      @forelse ($notif as $n)
                          @php
                              $readClass = $n->status_tl == 1 ? 'text-muted opacity-75' : 'fw-bold';
                              $link = $role == 3
                                  ? route('klien.project', $n->project_id)
                                  : route('finance.invoice', ['id' => $n->invoice_id]);
                          @endphp
                          <li class="form-check mb-2">
                              <input class="form-check-input notif-checkbox-tl" type="checkbox" name="notif_ids[]" value="{{ $n->id }}" id="notif{{ $n->id }}">
                              <label class="form-check-label w-100" for="notif{{ $n->id }}">
                                  <a href="{{ route('team_lead.project.plan', $n->project_id) }}" class="text-decoration-none d-block {{ $readClass }}">
                                      <div>{{ $n->title }}</div>
                                      <small>{{ $n->value }}</small>
                                  </a>
                              </label>
                          </li>
                      @empty
                          <li class="dropdown-item text-muted">Tidak ada notifikasi</li>
                      @endforelse
                  </form>
              </ul>
          </li>

          <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkboxes = document.querySelectorAll('.notif-checkbox-tl');
                const markReadBtn = document.getElementById('markReadBtn-tl');
                const deleteBtn = document.getElementById('deleteBtn-tl');

                function toggleButtons() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    markReadBtn.disabled = !anyChecked;
                    deleteBtn.disabled = !anyChecked;
                }

                checkboxes.forEach(cb => cb.addEventListener('change', toggleButtons));
                toggleButtons();
            });
            </script>

        @endif


        <!-- User Dropdown -->
        <li class="nav-item dropdown d-flex align-items-center">
          <a href="#" class="nav-link text-white font-weight-bold px-0 dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('storage/user_profile/'.Auth::user()->id.'/'.Auth::user()->profile) }}" alt="Profile" class="avatar avatar-sm rounded-circle me-2" style="border-radius: 9px; border: 2px solid white;">
            <span class="d-sm-inline d-none">{{ Auth::user()->username }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="{{ route('profile', Auth::user()->id) }}">Edit Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
          </ul>
        </li>

        <!-- Sidebar Toggler (Mobile) -->
        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
            </div>
          </a>
        </li>

        <!-- Settings Icon -->
        <li class="nav-item px-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white p-0">
            <i class="fas fa-cog cursor-pointer"></i>
          </a>
        </li>

      </ul>
    </div>
  </div>
</nav>
