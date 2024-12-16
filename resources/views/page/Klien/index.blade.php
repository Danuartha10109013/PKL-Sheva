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
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Project Name</p>
              <h5 class="font-weight-bolder">
                {{$project}}
              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
              <i class="fa-solid fa-diagram-project text-lg opacity-10" aria-hidden="true"></i>
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
                <a href="#"  data-bs-toggle="modal" data-bs-target="#progressModal-{{ $data->id }}">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Progres</p>
                <h5 class="font-weight-bolder">
                  {{ number_format($data->progres, 2) }}%
                </h5>
              </a>
              <div class="modal fade" id="progressModal-{{ $data->id }}" tabindex="-1" aria-labelledby="progressModalLabel-{{ $data->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="progressModalLabel-{{ $data->id }}">Progres Project: {{ $data->judul }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <canvas id="progressChart-{{ $data->id }}"></canvas>
                    </div>
                    </div>
                </div>
            </div>
                  
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
              <script>
                document.addEventListener('DOMContentLoaded', function () {
                // Event listener untuk setiap modal
                const modalId = document.getElementById('progressModal-{{ $data->id }}');
                modalId.addEventListener('shown.bs.modal', function () {
                    const ctx = document.getElementById('progressChart-{{ $data->id }}').getContext('2d');
                    new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Progres', 'Sisa'],
                        datasets: [{
                        data: [{{ $data->progres }}, {{ 100 - $data->progres }}],
                        backgroundColor: ['#4caf50', '#f44336'],
                        borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: false,
                        plugins: {
                        legend: {
                            position: 'top',
                        }
                        }
                    }
                    });
                });
                });
              </script>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                <i class="fa-solid fa-spinner text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  <div class="col-xl-3 col-sm-6 mb-xl-0">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Status</p>
              <h5 class="font-weight-bolder">
                <p class="text-{{ 
                  $data->progres == 0 ? 'danger' : 
                  ($data->progres > 0 && $data->progres < 100 ? 'warning' : 'success') 
              }}">
                  {{ 
                      $data->progres == 0 ? 'Belum Mulai' : 
                      ($data->progres > 0 && $data->progres < 100 ? 'Sedang Berjalan' : 'Selesai') 
                  }}
              </p>
              
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
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Price</p>
              <p class="">
                Rp. {{$data->biaya}}
              </p>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
              <i class="fa-solid fa-coins text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row mt-4">
  <div class="col-lg-7 mb-lg-0 mb-4">
    <div class="card z-index-2 h-100">
      <div class="card-header pb-0 pt-3 bg-transparent">
        <h6 class="text-capitalize">Project Plan</h6>
      </div>
      <div class="card-body p-3">
        <a href="{{route('klien.project',Auth::user()->id)}}" class="text-decoration-none text-dark">
            <div class="row align-items-center">
                <div class="col-md-4 d-flex align-items-center">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Go To Project Plan
                </div>
                <div class="col-md-8 text-end">
                    <img src="{{ asset('temas.png') }}" width="50%" alt="Project Image">
                </div>
            </div>
        </a>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card z-index-2 h-100">
      <div class="card-header pb-0 pt-3 bg-transparent">
        <h6 class="text-capitalize">Invoice</h6>
      </div>
      <div class="card-body p-3">
        <a href="{{route('klien.invoice',Auth::user()->id)}}" class="text-decoration-none text-dark">
            <div class="row align-items-center">
                <div class="col-md-4 d-flex align-items-center">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Go To Invoice
                </div>
                <div class="col-md-8 text-end">
                    <img src="{{ asset('ivc.png') }}" width="50%" alt="Project Image">
                </div>
            </div>
        </a>
      </div>
    </div>
  </div>

</div>
<div class="row mt-4">
  <div class="col-lg-7 mb-lg-0 mb-4">
    <div class="card ">
      <div class="card-header pb-0 p-3">
        <div class="d-flex justify-content-between">
          <h6 class="mb-0">Detail Project</h6>
        </div>
      </div>
      <div class="card-body">
        <p><strong>Nama Project : </strong>{{$data->judul}}</p>
        <p><strong>Project Manager : </strong>
        @php
          $pm = \App\Models\User::where('id',$data->pm_id)->value('name');
        @endphp
        {{$pm}}
        </p>
        <p><strong>Start Date : </strong>{{$data->start}}</p>
        <p><strong>End Date : </strong>{{$data->end}}</p>
        <p><strong>Project Plan : </strong>{{$data->launch == 1 ? 'Ready' : 'Not Ready'}}</p>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card">
      <div class="card-header pb-0 p-3">
        <h6 class="mb-0">Contacts</h6>
      </div>
      <div class="card-body p-3">
        <ul class="list-group">
          <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
            <div class="d-flex align-items-center">
              <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                <i class="ni ni-mobile-button text-white opacity-10"></i>
              </div>
              <div class="d-flex flex-column">
                <h6 class="mb-1 text-dark text-sm">Devices</h6>
                <span class="text-xs">250 in stock, <span class="font-weight-bold">346+ sold</span></span>
              </div>
            </div>
            <div class="d-flex">
              <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
            </div>
          </li>
          <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
            <div class="d-flex align-items-center">
              <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                <i class="ni ni-tag text-white opacity-10"></i>
              </div>
              <div class="d-flex flex-column">
                <h6 class="mb-1 text-dark text-sm">Tickets</h6>
                <span class="text-xs">123 closed, <span class="font-weight-bold">15 open</span></span>
              </div>
            </div>
            <div class="d-flex">
              <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
            </div>
          </li>
          <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
            <div class="d-flex align-items-center">
              <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                <i class="ni ni-box-2 text-white opacity-10"></i>
              </div>
              <div class="d-flex flex-column">
                <h6 class="mb-1 text-dark text-sm">Error logs</h6>
                <span class="text-xs">1 is active, <span class="font-weight-bold">40 closed</span></span>
              </div>
            </div>
            <div class="d-flex">
              <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
            </div>
          </li>
          <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
            <div class="d-flex align-items-center">
              <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                <i class="ni ni-satisfied text-white opacity-10"></i>
              </div>
              <div class="d-flex flex-column">
                <h6 class="mb-1 text-dark text-sm">Happy users</h6>
                <span class="text-xs font-weight-bold">+ 430</span>
              </div>
            </div>
            <div class="d-flex">
              <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection