@extends('layout.main')
@section('title')
Kelola Invoice || {{Auth::user()->name}}
@endsection
@section('pages')
Kelola Invoice
@endsection
@section('content')
<style>
    .nav-tabs .nav-link {
        color: white; /* Warna teks default */
        background-color: transparent;
    }

    .nav-tabs .nav-link.active {
        background-color: #007bff; /* Warna latar belakang aktif */
        color: white; /* Warna teks aktif */
    }

    .nav-tabs .nav-link:hover {
        color: #f8f9fa; /* Warna teks saat hover */
    }

    /* Background navbar untuk memastikan semua tab terlihat */
    .nav-tabs {
        background-color: transparent; /* Warna gelap agar teks putih terlihat */
        padding: 5px;
        border-radius: 5px;
    }
</style>
<ul class="nav nav-tabs" id="tableTabs">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#table0">All Data</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#table1">30%</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#table2">60%</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#table3">100%</a>
    </li>
</ul>

<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="table1">
        <div class="card">
            <div class="card-header pb-0 p-3">
                <div class="d-flex justify-content-between">
                    <h6 class="mb-2">List Of Project 30%</h6>
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
                        @if ($tiga)
                            @foreach ($tiga as $d)
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
                                    
                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateInvoiceModal{{$d->id}}">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <div class="modal fade" id="updateInvoiceModal{{$d->id}}" tabindex="-1" aria-labelledby="updateInvoiceLabel{{$d->id}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateInvoiceLabel{{$d->id}}">Update Invoice</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('finance.invoice.update', $d->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                   
                                                    <div class="modal-body">
                                                            <input type="hidden" class="form-control" id="project_id" name="project_id" value="{{ $d->id }}" required>
                                                        <div class="mb-3">
                                                            <label for="no_invoice" class="form-label">No Invoice</label>
                                                            <input type="text" class="form-control" id="no_invoice" name="no_invoice" value="{{ $invoice->no_invoice }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ppn" class="form-label">PPN</label>
                                                            <input type="text" class="form-control" id="ppn" name="ppn" value="{{ $invoice->ppn }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="kepada" class="form-label">Kepada</label>
                                                            <input type="text" class="form-control" id="kepada" name="kepada" value="{{ $invoice->kepada }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="npwp" class="form-label">NPWP</label>
                                                            <input type="text" class="form-control" id="npwp" name="npwp" value="{{ $invoice->npwp }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="alamat" class="form-label">Alamat</label>
                                                            <textarea class="form-control" id="alamat" name="alamat" required>{{ $invoice->alamat }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="harga" class="form-label">Harga</label>
                                                            @if ($d->harga)
                                                            <input type="number" class="form-control" id="harga" name="harga" value="{{ $invoice->harga }}" required>
                                                            @else
                                                            <input type="number" class="form-control" id="harga" name="harga" value="{{($d->biaya * 0.3)+(($d->biaya * 0.3)*$invoice->ppn)}}" readonly>
        
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="terbilang" class="form-label">Terbilang</label>
                                                            <input type="text" class="form-control" id="terbilang" name="terbilang" value="{{ $invoice->terbilang }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="pembuat" class="form-label">Pembuat</label>
                                                            <input type="text" class="form-control" id="pembuat" name="pembuat" value="{{ $invoice->pembuat }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="date" class="form-label">Tanggal</label>
                                                            <input type="date" class="form-control" id="date" name="date" value="{{ $invoice->date }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <a href="{{route('finance.invoice.print',$d->id)}}" class="btn btn-warning"><i class="fa-solid fa-print"></i></a>
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
                                        <div class="modal-body d-flex justify-content-center align-items-center" style="height: 100%;">
                                            <canvas id="progressChart-{{ $d->id }}"></canvas>
                                        </div>
                                            <div class="container mt-5 mb-5">
                                                @php
                                                    $ss = \App\Models\ProjectPlanM::where('project_id', $d->id)->value('fase');
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
                                <td> &nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->biaya * 0.3}}</td>
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
    </div>
</div>
<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="table2">
        <div class="card mt-5">
            <div class="card-header pb-0 p-3">
                <div class="d-flex justify-content-between">
                    <h6 class="mb-2">List Of Project 60%</h6>
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
                        @if ($enam)
                            @foreach ($enam as $d)
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
                                        $ids = \App\Models\ProjectPlanM::where('project_id',$d->id)->value('id');
                                    @endphp
                                    
        
                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateInvoiceModal1{{$d->id}}">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <div class="modal fade" id="updateInvoiceModal1{{$d->id}}" tabindex="-1" aria-labelledby="updateInvoiceLabel1{{$d->id}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateInvoiceLabel1{{$d->id}}">Update Invoice</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('finance.invoice.update', $d->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    @php
                                                    $ids1 = \App\Models\InvoiceM::where('project_id',$d->id)->value('id');
                                                    $invoice1 = \App\Models\InvoiceM::find($ids1);
                                                    // dd($invoice1);
                                                    @endphp
                                                    <div class="modal-body">
                                                            <input type="hidden" class="form-control" id="project_id" name="project_id" value="{{ $d->id }}" required>
                                                        <div class="mb-3">
                                                            <label for="no_invoice" class="form-label">No Invoice</label>
                                                            <input type="text" class="form-control" id="no_invoice" name="no_invoice" value="{{ $invoice1->no_invoice }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ppn" class="form-label">PPN</label>
                                                            <input type="text" class="form-control" id="ppn" name="ppn" value="{{ $invoice1->ppn }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="kepada" class="form-label">Kepada</label>
                                                            <input type="text" class="form-control" id="kepada" name="kepada" value="{{ $invoice1->kepada }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="npwp" class="form-label">NPWP</label>
                                                            <input type="text" class="form-control" id="npwp" name="npwp" value="{{ $invoice1->npwp }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="alamat" class="form-label">Alamat</label>
                                                            <textarea class="form-control" id="alamat" name="alamat" required>{{ $invoice1->alamat }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="harga" class="form-label">Harga</label>
                                                            <input type="number" class="form-control" id="harga" name="harga" value="{{($d->biaya * 0.6)-($d->biaya *0.3)+((($d->biaya * 0.6)-($d->biaya *0.3))*$invoice1->ppn)}}" readonly>
        
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="terbilang" class="form-label">Terbilang</label>
                                                            <input type="text" class="form-control" id="terbilang" name="terbilang" value="{{ $invoice1->terbilang }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="pembuat" class="form-label">Pembuat</label>
                                                            <input type="text" class="form-control" id="pembuat" name="pembuat" value="{{ $invoice1->pembuat }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="date" class="form-label">Tanggal</label>
                                                            <input type="date" class="form-control" id="date" name="date" value="{{ $invoice1->date }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <a href="{{route('finance.invoice.print',$d->id)}}" class="btn btn-warning"><i class="fa-solid fa-print"></i></a>
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
                                <td> &nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->biaya * 0.3}}</td>
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
    </div>
</div>
<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="table3">
        <div class="card mt-5">
            <div class="card-header pb-0 p-3">
                <div class="d-flex justify-content-between">
                    <h6 class="mb-2">List Of Project 100%</h6>
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
                        @if ($sepuluh)
                            @foreach ($sepuluh as $d)
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
                                        $ids = \App\Models\ProjectPlanM::where('project_id',$d->id)->value('id');
                                    @endphp
                                    @php
                                    $ids2 = \App\Models\InvoiceM::where('project_id',$d->id)->value('id');
                                    // dd($ids);
                                    $invoice2 = \App\Models\InvoiceM::find($ids2);
                                    @endphp
                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateInvoiceModal{{$d->id}}">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <div class="modal fade" id="updateInvoiceModal{{$d->id}}" tabindex="-1" aria-labelledby="updateInvoiceLabel{{$d->id}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateInvoiceLabel{{$d->id}}">Update Invoice</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('finance.invoice.update', $d->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                   
                                                    <div class="modal-body">
                                                            <input type="hidden" class="form-control" id="project_id" name="project_id" value="{{ $d->id }}" required>
                                                        <div class="mb-3">
                                                            <label for="no_invoice" class="form-label">No Invoice</label>
                                                            <input type="text" class="form-control" id="no_invoice" name="no_invoice" value="{{ $invoice2->no_invoice }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ppn" class="form-label">PPN</label>
                                                            <input type="text" class="form-control" id="ppn" name="ppn" value="{{ $invoice2->ppn }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="kepada" class="form-label">Kepada</label>
                                                            <input type="text" class="form-control" id="kepada" name="kepada" value="{{ $invoice2->kepada }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="npwp" class="form-label">NPWP</label>
                                                            <input type="text" class="form-control" id="npwp" name="npwp" value="{{ $invoice2->npwp }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="alamat" class="form-label">Alamat</label>
                                                            <textarea class="form-control" id="alamat" name="alamat" required>{{ $invoice2->alamat }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="harga" class="form-label">Harga</label>
                                                            <input type="number" class="form-control" id="harga" name="harga" value="{{((($d->biaya * 1)-($d->biaya * 0.6))+(($d->biaya)-($d->biaya * 0.6))*$invoice2->ppn)}}" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="terbilang" class="form-label">Terbilang</label>
                                                            <input type="text" class="form-control" id="terbilang" name="terbilang" value="{{ $invoice2->terbilang }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="pembuat" class="form-label">Pembuat</label>
                                                            <input type="text" class="form-control" id="pembuat" name="pembuat" value="{{ $invoice2->pembuat }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="date" class="form-label">Tanggal</label>
                                                            <input type="date" class="form-control" id="date" name="date" value="{{ $invoice2->date }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <a href="{{route('finance.invoice.print',$d->id)}}" class="btn btn-warning"><i class="fa-solid fa-print"></i></a>
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
                                <td> &nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->biaya * 0.3}}</td>
                                <td> &nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->biaya}}</td>
                                
        
        
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td>
                                <p>Data Tidak Ada</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabs = document.querySelectorAll(".nav-link");
        const allDataTab = document.querySelector('[href="#table0"]');
        const tabContents = document.querySelectorAll(".tab-pane");

        tabs.forEach(tab => {
            tab.addEventListener("click", function () {
                if (this === allDataTab) {
                    tabContents.forEach(content => content.classList.add("show", "active"));
                } else {
                    tabContents.forEach(content => content.classList.remove("show", "active"));
                    document.querySelector(this.getAttribute("href")).classList.add("show", "active");
                }
            });
        });
    });
</script>

@endsection
