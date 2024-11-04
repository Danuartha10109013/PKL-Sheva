@extends('layout.main')
@section('title')
Kelola Poject Plan || {{Auth::user()->name}}
@endsection
@section('pages')
Kelola Poject Plan
@endsection
@section('content')
<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
    <i class="fa fa-user-plus"></i> New Project Plan
</a>
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
                    <th>Customer</th>
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
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$d->judul}}</td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;
                        @php
                            $name = \App\Models\User::where('id',$d->customer_id)->value('name');
                        @endphp
                        {{$name}}</td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$d->start}}</td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$d->end}}</td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="" class="btn btn-primary"><i class="fas fa-keyboard"></i></a>
                        <a href="" class="btn btn-success"><i class="fa fa-eye"></i></a>
                        <a href="" class="btn btn-warning"><i class="fa fa-pencil-square"></i></a>
                        <a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->biaya}},00</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pm.k-project.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Project Title</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer" class="form-label">Customer</label>
                        <select type="text" class="form-control" id="customer" name="customer" required>
                            <option value="" selected disabled>--Pilih Customer Or Add New</option>
                            @foreach ($customer as $c)
                            <option value="{{$c->id}}" >{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start" name="start" required>
                    </div>
                    <div class="mb-3">
                        <label for="end" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end" name="end" required>
                    </div>
                    <div class="mb-3">
                        <label for="biaya" class="form-label">Total Cost</label>
                        <input type="number" class="form-control" id="biaya" name="biaya">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Project</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection