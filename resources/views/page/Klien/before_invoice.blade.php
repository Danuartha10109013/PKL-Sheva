@extends('layout.main')

@section('title')
    List Project  || {{ Auth::user()->name }}
@endsection

@section('pages')
    List Project 
@endsection

@section('content')
<div class="card">
    <div class="card-header pb-0">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between align-items-center">
                <h6>List of Project</h6>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table align-items-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Team Leader</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                    <th>Total Biaya</th>
                    <th>Status</th>
                    <th>30%</th>
                    <th>60%</th>
                    <th>90%</th>
                    <th>100%</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($project as $p)
                    
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$loop->iteration}}</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$p->judul}}</td>
                     
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;
                        @php
                            $team_lead = \App\Models\User::find($p->team_leader_id);
                        @endphp
                        {{$team_lead->name}}</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$p->start}}</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$p->end}}</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp; <a href="{{route('klien.invoice',$p->id)}}" title="Go to Current Invoice" class="btn btn-primary"><i class="fa fa-file-invoice"></i></a></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Rp. {{ number_format($p->biaya, 2, ',', '.') }}</td>
                        @php
                      $progres = $p->progres;
                      $pesan = '';
                      $invoice = \App\Models\InvoiceM::where('project_id',$p->id)->first();
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
                        @php
                            $invoice = \App\Models\InvoiceM::where('project_id', $p->id)->first();
                        @endphp
                        <!-- Kolom 30% -->
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;
                            @if ($invoice && $invoice->bukti_pembayaran_30)
                                <img src="{{ asset('storage/' . $invoice->bukti_pembayaran_30) }}" width="90%" alt="bukti">
                            @elseif ($invoice && $p->progres >= 30)
                                
                                Belum Ada Bukti <br>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#buktiModal30-{{ $p->id }}">
                                    Tambahkan Bukti
                                </a>
                                <!-- Modal 30% -->
                                <div class="modal fade" id="buktiModal30-{{ $p->id }}" tabindex="-1" aria-labelledby="buktiModalLabel30-{{ $p->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('klien.p.invoice.bukti30', $invoice->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="buktiModalLabel30-{{ $p->id }}">Upload Bukti Pembayaran 30%</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="file" name="bukti30" accept="image/*" class="form-control" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">Upload</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <span class="text-danger">Invoice belum dikirim</span>
                            @endif
                        </td>

                        <!-- Kolom 60% -->
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;
                            @if ($invoice && $invoice->bukti_pembayaran_60)
                                <img src="{{ asset('storage/' . $invoice->bukti_pembayaran_60) }}" width="90%" alt="bukti">
                            @elseif ($invoice && $p->progres >= 60)
                                Belum Ada Bukti <br>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#buktiModal60-{{ $p->id }}">
                                    Tambahkan Bukti
                                </a>
                                <div class="modal fade" id="buktiModal60-{{ $p->id }}" tabindex="-1" aria-labelledby="buktiModalLabel60-{{ $p->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('klien.p.invoice.bukti60', $invoice->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="buktiModalLabel60-{{ $p->id }}">Upload Bukti Pembayaran 60%</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="file" name="bukti60" accept="image/*" class="form-control" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">Upload</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <span class="text-danger">Invoice belum dikirim</span>
                            @endif
                        </td>

                        <!-- Kolom 90% -->
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;
                            @if ($invoice && $invoice->bukti_pembayaran_90)
                                <img src="{{ asset('storage/' . $invoice->bukti_pembayaran_90) }}" width="90%" alt="bukti">
                            @elseif ($invoice && $p->progres >= 90)
                                Belum Ada Bukti <br>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#buktiModal90-{{ $p->id }}">
                                    Tambahkan Bukti
                                </a>
                                <div class="modal fade" id="buktiModal90-{{ $p->id }}" tabindex="-1" aria-labelledby="buktiModalLabel90-{{ $p->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('klien.p.invoice.bukti90', $invoice->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="buktiModalLabel90-{{ $p->id }}">Upload Bukti Pembayaran 90%</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="file" name="bukti90" accept="image/*" class="form-control" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">Upload</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <span class="text-danger">Invoice belum dikrim</span>
                            @endif
                        </td>

                        <!-- Kolom 100% -->
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;
                            @if ($invoice && $invoice->bukti_pembayaran_100)
                                <img src="{{ asset('storage/' . $invoice->bukti_pembayaran_100) }}" width="90%" alt="bukti">
                            @elseif ($invoice && $p->progres >= 100)
                                Belum Ada Bukti <br>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#buktiModal100-{{ $p->id }}">
                                    Tambahkan Bukti
                                </a>
                                <div class="modal fade" id="buktiModal100-{{ $p->id }}" tabindex="-1" aria-labelledby="buktiModalLabel100-{{ $p->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('klien.p.invoice.bukti100', $invoice->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="buktiModalLabel100-{{ $p->id }}">Upload Bukti Pembayaran 100%</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="file" name="bukti100" accept="image/*" class="form-control" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">Upload</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <span class="text-danger">Invoice belum dikirim</span>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection