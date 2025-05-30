@extends('layout.main')
@section('title')
Kelola Poject  || {{Auth::user()->name}}
@endsection
@section('pages')
Kelola Poject 
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
            <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$d->judul}}</td>
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
                <a href="{{route('finance.project.plan',$d->id)}}" class="btn btn-success" title="Go to Project Plan"><i class="fa fa-eye"></i></a>
                
                
                @if ($d->launch == 1)
                <a href="{{route('forum',$d->id)}}" class="btn btn-light" title="Go To Forum"><i class="fab fa-rocketchat"></i></a>
                @endif

                

              </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->biaya}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

    </div>
</div>


@endsection