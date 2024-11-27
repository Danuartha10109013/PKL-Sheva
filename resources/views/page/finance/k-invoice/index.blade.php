@extends('layout.main')
@section('title')
Kelola Invoice || {{Auth::user()->name}}
@endsection
@section('pages')
Kelola Invoice
@endsection
@section('content')

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
                                                    <input type="number" class="form-control" id="harga" name="harga" value="{{$d->biaya * 0.3}}" required>

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
                            
                            <a href="{{route('finance.invoice.print',$d->id)}}" class="btn btn-warning"><i class="fa-solid fa-print"></i></a>
            
                            
            
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
                            
                            <a href="{{route('finance.invoice.print',$d->id)}}" class="btn btn-warning"><i class="fa-solid fa-print"></i></a>
            
                            
            
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

@endsection
