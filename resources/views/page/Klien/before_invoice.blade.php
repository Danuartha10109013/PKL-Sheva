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
                            // dd($team_lead);
                        @endphp
                        {{$team_lead->name}}</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$p->start}}</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$p->end}}</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp; <a href="{{route('klien.invoice',$p->id)}}" title="Go to Current Invoice" class="btn btn-primary"><i class="fa fa-file-invoice"></i></a></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Rp. {{ number_format($p->biaya, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection