@extends('layout.main')
@section('title')
Dashboard || {{Auth::user()->name}}
@endsection
@section('pages')
Dashboard
@endsection
@section('content')
<style>
  .scroll-container {
    display: flex;
    overflow-x: auto;
    gap: 1.5rem; /* Gap antar card */
    padding-bottom: 1rem;
  }

  .scroll-container::-webkit-scrollbar {
    height: 8px;
  }

  .scroll-container::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 4px;
  }

  .card-utama {
    min-width: 18rem;
    max-width: 18rem;
    flex: 0 0 auto;
  }

  .card-title, .card-text {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>
<div class="row">
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Project</p>
              <h5 class="font-weight-bolder">
                @php
                  $project = \App\Models\ProjectM::all()->count()
                @endphp
                {{$project}}
              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
              <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Team Leader</p>
              <h5 class="font-weight-bolder">
                @php
                  $tl = \App\Models\User::where('role',1)->count();
                @endphp
                {{$tl}}
              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
              <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Clients</p>
              <h5 class="font-weight-bolder">
                {{-- {{$client}} --}}
                @php
                  $client = \App\Models\User::where('role',3)->count();
                @endphp
                {{$client}}
              </h5>
              
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
              <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Finance</p>
              <h5 class="font-weight-bolder">
                {{-- {{$client}} --}}
                @php
                  $fn = \App\Models\User::where('role',2)->count();
                @endphp
                {{$fn}}
              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
              <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid px-4 mt-4">
  {{-- Scrollable Cards Section --}}
  <div class="row">
    <div class="d-flex flex-nowrap overflow-auto gap-4">
      @foreach ($datain->take(8) as $d)
        @php
          $ids = App\Models\ProjectPlanM::where('project_id', $d->id)->value('id');
        @endphp
        <div class="card card-utama" style="width: 18rem; min-width: 18rem;">
          <a href="{{ route('team_lead.project.plan', ['id' => $d->id]) }}" class="text-decoration-none text-dark">
            <img class="card-img-top" src="{{ asset('tlb1.png') }}" alt="Project Image">
            <div class="card-body">
              <h5 class="card-title text-truncate">{{ $d->judul }}</h5>
              @php
                $plantarget = App\Models\ProjectPlanM::find($ids);
                $pmname = App\Models\User::where('id', $plantarget->update_by)->value('name');
              @endphp
              <p class="card-text small mb-0">Last updated: {{ $d->updated_at->format('H:i:s') }}</p>
              <p class="card-text small">On {{ $d->updated_at->format('d-m-Y') }} by {{ $pmname }}</p>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>

  {{-- Project Summary Table --}}
  <div class="card mt-5 mb-4">
    <div class="card-header pb-0 p-3">
      <h6 class="mb-0">Project Summary</h6>
    </div>

    <div class="table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Customer</th>
            <th>Progres</th>
            <th>Deadline</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($datain as $d)
            @php
              $progress = App\Models\ProjectM::where('id', $d->id)->value('progres');
              $customerName = $customer->where('id', $d->customer_id)->pluck('name')->first() ?? 'N/A';
            @endphp
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td class="text-truncate" style="max-width: 200px;">{{ $d->judul }}</td>
              <td>{{ $customerName }}</td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="progress flex-grow-1" style="height: 20px;">
                    <div class="progress-bar" role="progressbar"
                      style="width: {{ $progress }}%; background-color: #0a3d5f;"
                      aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                    </div>
                  </div>
                  <small>{{ $progress }}%</small>
                </div>
              </td>
              <td>{{ \Carbon\Carbon::parse($d->end)->format('d-m-Y') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection