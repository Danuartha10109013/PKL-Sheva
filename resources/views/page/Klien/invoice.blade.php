@extends('layout.main')
@section('title')
Client's Invoice || {{Auth::user()->name}}
@endsection
@section('pages')
Client's Invoice
@endsection
@section('content')

<div class="card">
    <div class="card-header pb-0 p-3">
        <div class="d-flex justify-content-between">
            <h6 class="mb-2">The Project</h6>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-items-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Progres</th>
                    <th>Customer</th>
                    <th>Team Leader</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                    <th>Pembayaran </th>
                    <th>Total Biaya</th>
                </tr>
            </thead>
            <tbody>
                @if ($data)
                    @foreach ($data as $d)
                    <tr>
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$loop->iteration}}</td>
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$d->judul}}</td>
                    
                        <td> &nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($d->progres, 2) }}%</td>
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
                                $ids = \App\Models\InvoiceM::where('project_id',$d->id)->value('id');
                                // dd($ids);
                                $invoice = \App\Models\InvoiceM::find($ids);
                            @endphp
                            
                            
                            
                            
                            <a href="{{route('klien.p.invoice',$d->id)}}" class="btn btn-warning"><i class="fa-solid fa-print"></i></a>
                            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#progressModal-{{ $d->id }}">
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
                        @if ($d->progres >= 30 && $d->progres <60)
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->biaya * 0.3}}</td>
                        @elseif ($d->progres >= 60 && $d->progres <100)
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;Rp. {{($d->biaya * 0.6)-($d->biaya * 0.3)}}</td>
                        @elseif ($d->progres == 100)
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;Rp. {{($d->biaya * 1)-($d->biaya * 0.6)-($d->biaya * 0.3)}}</td>
                        @endif
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->biaya}}</td>
                        


                    </tr>
                    @endforeach
                @else
                <p>Data Tidak Ada</p>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection