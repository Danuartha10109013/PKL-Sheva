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
@php
$index = ['nol', 'tiga', 'enam', 'sembilan', 'sepuluh'];
$labels = ['<30%', '30%', '60%', '90%', '100%'];
@endphp

<!-- TAB HEADER -->
<ul class="nav nav-tabs" id="tableTabs">
    @foreach ($index as $key => $i)
        <li class="nav-item">
            <a class="nav-link {{ $key == 0 ? 'active' : '' }}" data-bs-toggle="tab" href="#table{{ $i }}">{{ $labels[$key] }}</a>
        </li>
    @endforeach
</ul>
<div class="tab-content mt-3">
    @foreach ($index as $key => $i)
    <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="table{{ $i }}">
        <div class="card">
            <div class="card-header pb-0 p-3">
                <div class="d-flex justify-content-between">
                    <h6 class="mb-2">List Of Project 
                        @if ($i == 'nol') <30%
                        @elseif ($i == 'tiga') 30%
                        @elseif ($i == 'enam') 60%
                        @elseif ($i == 'sembilan') 90%
                        @elseif ($i == 'sepuluh') 100%
                        @endif
                    </h6>
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
                            <th>Pembayaran</th>
                            <th>Total Biaya</th>
                            <th>30%</th>
                            <th>60%</th>
                            <th>90%</th>
                            <th>100%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $isi = $$i; // e.g., $nol, $tiga, $enam, etc.
                        @endphp
                        @if (!empty($isi))
                            @foreach ($isi as $d)
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
                                        
                                        <!-- Button -->
                                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#mailModal{{$d->id}}">
                                            <i class="fa-solid fa-envelope"></i>
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="mailModal{{ $d->id }}" tabindex="-1" aria-labelledby="mailModalLabel{{ $d->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                        
                                                    <form action="{{ route('finance.invoice.mail', $d->id) }}" method="POST">
                                                        @csrf
                                        
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="mailModalLabel{{ $d->id }}">Kirim Invoice</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                        
                                                        <div class="modal-body">
                                                            <p>Apakah anda yakin ingin mengirim Email Invoice ke Klien ?</p>
                                        
                                                            <div class="mb-3">
                                                                <label for="typeSelect{{ $d->id }}" class="form-label">Select Invoice Type</label>
                                                                <select name="type" id="typeSelect{{ $d->id }}" class="form-select" required>
                                                                    <option value="">-- Silahkan Pilih Jenis --</option>
                                                                    <option value="30">30%</option>
                                                                    <option value="60">60%</option>
                                                                    <option value="90">90%</option>
                                                                    <option value="100">100%</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                        
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Yes, Send</button>
                                                        </div>
                                                    </form>
                                        
                                                </div>
                                            </div>
                                        </div>
                                         


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
                                                                <input type="text" class="form-control" id="no_invoice" name="no_invoice" value="{{ $invoice->no_invoice }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="ppn" class="form-label">PPN</label>
                                                                <input type="text" class="form-control" id="ppn" name="ppn" value="{{ $invoice->ppn }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="kepada" class="form-label">Kepada</label>
                                                                <input type="text" class="form-control" id="kepada" name="kepada" placeholder="Masukan Nama Customer" value="{{ $invoice->kepada }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="npwp" class="form-label">NPWP</label>
                                                                <input type="text" class="form-control" id="npwp" name="npwp" placeholder="Masukan NPWP" value="{{ $invoice->npwp }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="alamat" class="form-label">Alamat</label>
                                                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukan Alamat" required>{{ $invoice->alamat }}</textarea>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label for="pembuat" class="form-label">Pembuat</label>
                                                                <input type="text" class="form-control" id="pembuat" name="pembuat" value="{{ $invoice->pembuat ?? Auth::user()->name}}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="date" class="form-label">Tanggal</label>
                                                                <input type="date" class="form-control" id="date" name="date" value="{{ $invoice->date }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="date" class="form-label">Batas Pembayaran</label>
                                                                <input type="date" class="form-control" id="date" name="due_date" value="{{ $invoice->due_date }}">
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
                                    <td> 
                                        @if ($i == 'nol')
                                        &nbsp;&nbsp;&nbsp;&nbsp;Rp. 0
                                        @elseif ($i == 'tiga')
                                        &nbsp;&nbsp;&nbsp;&nbsp;{{'Rp. ' . number_format($d->biaya * 0.30, 0, ',', '.')}}
                                        @elseif ($i == 'enam')
                                        &nbsp;&nbsp;&nbsp;&nbsp; {{'Rp. ' . number_format(($d->biaya * 0.60) - ($d->biaya * 0.30), 0, ',', '.')}}
                                        @elseif ($i == 'sembilan')
                                        &nbsp;&nbsp;&nbsp;&nbsp; {{'Rp. ' . number_format(($d->biaya * 0.90) - ($d->biaya * 0.60), 0, ',', '.')}}
                                        @elseif ($i == 'sepuluh')
                                        &nbsp;&nbsp;&nbsp;&nbsp; {{'Rp. ' . number_format(($d->biaya * 0.100) - ($d->biaya * 0.9), 0, ',', '.')}}
                                        @endif
                                    </td>
                                    <td> &nbsp;&nbsp;&nbsp;&nbsp;Rp. {{number_format($d->biaya, 0, ',', '.')}}</td>
                                    <td>
                                        @php
                                            $inv = \App\Models\InvoiceM::where('project_id',$d->id)->value('id');
                                            $invoice = \App\Models\InvoiceM::find($inv);
                                        @endphp
                                        @if (!empty($invoice->{'30'}))
                                            &nbsp;&nbsp;&nbsp;&nbsp;{{ $invoice->{'30'} }}
                                        @else
                                            &nbsp;&nbsp;&nbsp;&nbsp;Belum Di Bayar  
                                            <br>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="#" class="text text-danger" data-bs-toggle="modal" data-bs-target="#confirmModal30{{ $invoice->id }}">
                                                Konfirmasi
                                            </a>
                                        @endif

                                        <div class="modal fade" id="confirmModal30{{$invoice->id}}" tabindex="-1" aria-labelledby="confirmModal30Label{{$invoice->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmModal30Label{{$invoice->id}}">Konfirmasi Pembayaran 30%</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin mengonfirmasi pembayaran ini ?
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    
                                                    <!-- Confirm button, link to your invoice mail route or JS action -->
                                                    <form action="{{ route('finance.invoice.confirm30', $invoice->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Ya, Konfirmasi</button>
                                                    </form>
                                                </div>
    
                                                </div>
                                            </div>
                                        </div>
                                    
                                        </td>
                                    <td>
                                        @if (!empty($invoice->{'60'}))
                                            &nbsp;&nbsp;&nbsp;&nbsp;{{ $invoice->{'60'} }}
                                        @else
                                            &nbsp;&nbsp;&nbsp;&nbsp;Belum Di Bayar  
                                            <br>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="#" class="text text-danger" data-bs-toggle="modal" data-bs-target="#confirmModal60{{ $invoice->id }}">
                                                Konfirmasi
                                            </a>
                                        @endif
                                        <div class="modal fade" id="confirmModal60{{$invoice->id}}" tabindex="-1" aria-labelledby="confirmModal60Label{{$invoice->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmModal60Label{{$invoice->id}}">Konfirmasi Pembayaran 60%</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin mengonfirmasi pembayaran ini?
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    
                                                    <!-- Confirm button, link to your invoice mail route or JS action -->
                                                    <form action="{{ route('finance.invoice.confirm60', $invoice->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Ya, Konfirmasi</button>
                                                    </form>
                                                </div>
    
                                                </div>
                                            </div>
                                            </div>
                                    </td>
                                    <td>
                                        @if (!empty($invoice->{'90'}))
                                            &nbsp;&nbsp;&nbsp;&nbsp;{{ $invoice->{'90'} }}
                                        @else
                                            &nbsp;&nbsp;&nbsp;&nbsp;Belum Di Bayar  
                                            <br>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="#" class="text text-danger" data-bs-toggle="modal" data-bs-target="#confirmModal90{{ $invoice->id }}">
                                                Konfirmasi
                                            </a>
                                        @endif
                                        <div class="modal fade" id="confirmModal90{{$d->id}}" tabindex="-1" aria-labelledby="confirmModal90Label{{$d->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmModal90Label{{$d->id}}">Konfirmasi Pembayaran 90%</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin mengonfirmasi pembayaran ini?
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    
                                                    <!-- Confirm button, link to your invoice mail route or JS action -->
                                                    <form action="{{ route('finance.invoice.confirm90', $d->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Ya, Konfirmasi</button>
                                                    </form>
                                                </div>
    
                                                </div>
                                            </div>
                                            </div>
                                    </td>
                                    <td>
                                        @if (!empty($invoice->{'100'}))
                                            &nbsp;&nbsp;&nbsp;&nbsp;{{ $invoice->{'100'} }}
                                        @else
                                            &nbsp;&nbsp;&nbsp;&nbsp;Belum Di Bayar  
                                            <br>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="#" class="text text-danger" data-bs-toggle="modal" data-bs-target="#confirmModal100{{ $invoice->id }}">
                                                Konfirmasi
                                            </a>
                                        @endif
                                        <div class="modal fade" id="confirmModal100{{$d->id}}" tabindex="-1" aria-labelledby="confirmModal100Label{{$d->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmModal100Label{{$d->id}}">Konfirmasi Pembayaran 100%</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin mengonfirmasi pembayaran ini?
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    
                                                    <!-- Confirm button, link to your invoice mail route or JS action -->
                                                    <form action="{{ route('finance.invoice.confirm100', $d->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Ya, Konfirmasi</button>
                                                    </form>
                                                </div>
    
                                                </div>
                                            </div>
                                            </div>
                                    </td>
            
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" class="text-center">No data available</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabs = document.querySelectorAll(".nav-link");
        const tabContents = document.querySelectorAll(".tab-pane");
    
        tabs.forEach(tab => {
            tab.addEventListener("click", function (e) {
                e.preventDefault();
    
                // Remove active state from all tabs and panes
                tabs.forEach(t => t.classList.remove("active"));
                tabContents.forEach(c => c.classList.remove("show", "active"));
    
                // Add active to clicked tab
                this.classList.add("active");
    
                // Show the corresponding pane
                const target = this.getAttribute("href");
                const content = document.querySelector(target);
                if (content) {
                    content.classList.add("show", "active");
                }
            });
        });
    });
    </script>
    
@endsection
