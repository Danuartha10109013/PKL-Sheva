@extends('layout.main')
@section('title')
Dashboard || {{Auth::user()->name}}
@endsection
@section('pages')
Dashboard
@endsection
@section('content')
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
              <p class=" mb-0 text-uppercase font-weight-bold" style="font-size: 12px">Total Team Leader</p>
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

<div class="card mt-4">
  <div class="card-header pb-0 p-3">
      <div class="d-flex justify-content-between">
          <h6 class="mb-2">Project Summary</h6>
      </div>
  </div>
  <div class="table-responsive">
      <table class="table align-items-center">
  <thead>
      <tr>
          <th>No</th>
          <th>Judul</th>
          <th>Customer</th>
          <th>progres</th>
          <th>Deadline</th>
      </tr>
  </thead>
  <tbody>
    @foreach ($data as $d)
    <tr>
        <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$loop->iteration}}</td>
        <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$d->judul}}</td>
        <td> &nbsp;&nbsp;&nbsp;&nbsp;
            {{-- Cari nama customer berdasarkan ID --}}
            {{ $customer->where('id', $d->customer_id)->pluck('name')->first() ?? 'N/A' }}
        </td>
        <td>
          @php
            $progresin = App\Models\ProjectM::where('id', $d->id)->value('progres');
          @endphp 
           <div class="progress" style="height: 20px; width: 300px;">
            <div class="progress-bar" role="progressbar" 
              style="width: {{ $progresin }}%; background-color: #0a3d5f;" 
              aria-valuenow="{{ $progresin }}" 
              aria-valuemin="0" 
              aria-valuemax="100">
            </div>
          </div>
          <span class="ml-2">{{ $progresin }}%</span>
        
        </td>
        <td> &nbsp;&nbsp;&nbsp;&nbsp;{{\Carbon\Carbon::parse($d->end)->format('d-m-Y')}}</td>
    </tr>
      @endforeach
  </tbody>
</table>

  </div>
</div>


@endsection