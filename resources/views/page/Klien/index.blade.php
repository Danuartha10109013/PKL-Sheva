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
                <a href="#"  data-bs-toggle="modal" data-bs-target="#progressModal-{{ $data->id }}" title="Show Progres">
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
                    <div class="container mt-5 mb-5">
                      @php
                          $ss = \App\Models\ProjectPlanM::where('project_id', $data->id)->value('fase');
                          $datain = json_decode($ss);
                      @endphp
                      <p class="text-bolder">Detail Fase</p>
                      <table style="width: 100%; border-collapse: collapse; text-align: left; margin-top: 10px;">
                          <thead style="background-color: #f2f2f2; border-bottom: 1px solid #ddd;">
                              <tr>
                                  <th style="padding: 8px; border: 1px solid #ddd;">No</th>
                                  <th style="padding: 8px; border: 1px solid #ddd;">Date</th>
                                  <th style="padding: 8px; border: 1px solid #ddd;">Name</th>
                                  <th style="padding: 8px; border: 1px solid #ddd;">Status</th>
                              </tr>
                          </thead>
                          <tbody>
                              @if($datain) <!-- Check if $datain has valid data -->
                                  @foreach ($datain as $da)
                                      <tr>
                                          <td style="padding: 8px; border: 1px solid #ddd;">{{ $loop->iteration }}</td>
                                          <td style="padding: 8px; border: 1px solid #ddd;">{{ $da->start ?? '-' }} - {{ $da->end ?? '-' }}</td>
                                          <td style="padding: 8px; border: 1px solid #ddd; white-space: normal; word-break: break-word;">
                                              {{ $da->scrum_name ?? '-' }}
                                          </td>
                                          <td style="padding: 8px; border: 1px solid #ddd;">
                                              <span style="color: {{ $da->status == 1 ? 'green' : 'red' }};">
                                                  {{ $da->status == 1 ? 'Completed' : 'In Progress' }}
                                              </span>
                                          </td>
                                      </tr>
                                  @endforeach
                              @else
                                  <tr>
                                      <td colspan="4" style="padding: 8px; border: 1px solid #ddd; text-align: center;">No data available</td>
                                  </tr>
                              @endif
                          </tbody>
                      </table>
                      
                      

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
              <p style="font-size: 14px" class="">
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
        <a href="{{route('klien.project',$data->id)}}" class="text-decoration-none text-dark">
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
        <a href="{{route('klien.invoice',$data->id)}}" class="text-decoration-none text-dark">
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
    <div class="card z-index-2 h-100">
      <div class="card-header pb-0 pt-3 bg-transparent">
        <h6 class="text-capitalize">Pembayaran</h6>
      </div>
      <div class="card-body p-3">
        @php
            $in = \App\Models\InvoiceM::where('project_id', $data->id)->value('id');
            $invoice = \App\Models\InvoiceM::find($in);
        @endphp
    
        <div class="row">
            <div class="col-12 mb-2">
                <strong>Status Pembayaran:</strong>
            </div>
    
            <div class="col-md-6">
                Termin I (30%) : <span class="badge bg-{{ ($invoice['30'] ?? '') == 'payed' ? 'success' : 'secondary' }}">
                    {{ ($invoice['30'] ?? '') == 'payed' ? 'Lunas' : 'Belum Lunas' }}
                </span>
            </div>
            <div class="col-md-6">
                Termin II (60%) : <span class="badge bg-{{ ($invoice['60'] ?? '') == 'payed' ? 'success' : 'secondary' }}">
                    {{ ($invoice['60'] ?? '') == 'payed' ? 'Lunas' : 'Belum Lunas' }}
                </span>
            </div>
            <div class="col-md-6">
                Termin III (90%) : <span class="badge bg-{{ ($invoice['90'] ?? '') == 'payed' ? 'success' : 'secondary' }}">
                    {{ ($invoice['90'] ?? '') == 'payed' ? 'Lunas' : 'Belum Lunas' }}
                </span>
            </div>
            <div class="col-md-6">
                Termin IV (100%) : <span class="badge bg-{{ ($invoice['100'] ?? '') == 'payed' ? 'success' : 'secondary' }}">
                    {{ ($invoice['100'] ?? '') == 'payed' ? 'Lunas' : 'Belum Lunas' }}
                </span>
            </div>
        </div>
    </div>
    
    </div>
  </div>
</div>
@endsection