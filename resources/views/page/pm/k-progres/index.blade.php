@extends('layout.main')
@section('title')
Kelola Progres || {{Auth::user()->name}}
@endsection
@section('pages')
Kelola Progres
@endsection
@section('content')

<div class="card">
    <div class="card-header pb-0 p-3">
        <div class="d-flex justify-content-between">
            <h6 class="mb-2">List Of Project</h6>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-items-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Progres</th>
                    <th>Status</th>
                    <th>Customer</th>
                    <th>Team Leader</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                    <th>Total Biaya</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$loop->iteration}}</td>
                    <td class="text-wrap text-break px-1">
                        {{ $d->judul }}
                    </td>

                  
                  <td> &nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($d->progres, 2) }}%</td>
                     @php
                      $progres = $d->progres;
                      $pesan = '';
                      $invoice = \App\Models\InvoiceM::where('project_id',$d->id)->first();
                      // dd($invoice->{'30'});
                      if ($progres >= 100) {
                          $pesan = 'Invoice telah dikirim untuk termin 4';
                          if($invoice->{'100'} == 'payed'){
                            $sts = 'Tagihan Telah Dibayar';
                            $color = 'success';
                          }else {
                            $sts = 'Tagihan Belum DIbayar';
                            $color = 'danger';
                          }
                      } elseif ($progres >= 90) {
                          $pesan = 'Invoice telah dikirim untuk termin 3';
                          if($invoice->{'90'} == 'payed'){
                             $sts = 'Tagihan Telah Dibayar';
                            $color = 'success';
                          }else {
                            $sts = 'Tagihan Belum DIbayar';
                            $color = 'danger';
                          }
                      } elseif ($progres >= 60) {
                          $pesan = 'Invoice telah dikirim untuk termin 2';
                          if($invoice->{'60'} == 'payed'){
                            $sts = 'Tagihan Telah Dibayar';
                            $color = 'success';
                          }else {
                            $sts = 'Tagihan Belum DIbayar';
                            $color = 'danger';
                          }
                      } elseif ($progres >= 30) {
                          $pesan = 'Invoice telah dikirim untuk termin 1';
                          if($invoice->{'30'} == 'payed'){
                             $sts = 'Tagihan Telah Dibayar';
                            $color = 'success';
                          }else {
                            $sts = 'Tagihan Belum DIbayar';
                            $color = 'danger';
                          }
                      }
                  @endphp
                  <td >&nbsp;&nbsp;&nbsp;&nbsp;
                      {{-- {{ number_format($progres, 2) }}% --}}
                      @if ($pesan && $sts && $color)
                          <small class="text-muted">{{ $pesan }}</small>
                          <br>
                          &nbsp;&nbsp;&nbsp;&nbsp;<small class="text text-{{$color}}">{{ $sts }}</small>
                      @else
                      <small>Progres belum dimulai</small>
                      @endif
                  </td>

                    {{-- <td> &nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($d->progres, 2) ?? >30|>60|>90|100 Invoice telah dikirim untuk termin 1 | 2 | 3 | 4}}%</td> --}}
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;
                        @php
                            $name = \App\Models\User::where('id', $d->customer_id)->value('name');
                            $name_tl = \App\Models\User::where('id', $d->team_leader_id)->value('name');
                        @endphp
                        {{$name}}
                    </td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$name_tl}}</td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$d->start}}</td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$d->end}}</td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;
                        @php
                            $ids = \App\Models\ProjectPlanM::where('project_id',$d->id)->value('id');
                        @endphp
                        
                        @if (Auth::user()->role == 0)
                        <a href="{{route('pm.k-progres.progres',$d->id)}}" class="btn btn-light" data-bs-toggle="toltip" title="Kelola Progres"><i class="fa-solid fa-bars-progress"></i></a>
                        @endif
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" title="Show Progres" data-bs-target="#progressModal-{{ $d->id }}">
                            <i class="fa-solid fa-spinner"></i>
                          </a>
                          
                          <div class="modal fade" id="progressModal-{{ $d->id }}" tabindex="-1" aria-labelledby="progressModalLabel-{{ $d->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="progressModalLabel-{{ $d->id }}">Progres Project: {{ $d->judul }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                  <canvas id="progressChart-{{ $d->id }}"></canvas>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                          <script>
                          document.addEventListener('DOMContentLoaded', function () {
                            // Event listener untuk setiap modal
                            const modalId = document.getElementById('progressModal-{{ $d->id }}');
                            modalId.addEventListener('shown.bs.modal', function () {
                              const ctx = document.getElementById('progressChart-{{ $d->id }}').getContext('2d');
                              new Chart(ctx, {
                                type: 'pie',
                                data: {
                                  labels: ['Progres', 'Sisa'],
                                  datasets: [{
                                    data: [{{ $d->progres }}, {{ 100 - $d->progres }}],
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
                          
                         

        
                      </td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->biaya}}</td>
                    


                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
