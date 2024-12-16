@extends('layout.main')

@section('title')
Access Denied || {{ Auth::user()->name }}
@endsection

@section('pages')
Unauthorized Access
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="text-center mt-5">
                <img src="{{ asset('vendor/zen.png') }}" alt="Access Denied" style="max-width: 200px; margin-bottom: 20px;">
                <h1 class="text-danger">403 - Forbidden</h1>
                <p class="text-muted">You do not have the required permissions to access this page.</p>
                @if (Auth::user()->role == 0)
                <a href="{{route('pm.PM')}}" class="btn btn-primary mt-3">Go Back to Home</a>
                @elseif (Auth::user()->role == 3)
                <a href="{{route('klien.klien')}}" class="btn btn-primary mt-3">Go Back to Home</a>
                @elseif (Auth::user()->role == 2)
                <a href="{{route('finance.finance')}}" class="btn btn-primary mt-3">Go Back to Home</a>
                @elseif (Auth::user()->role == 1)
                <a href="{{route('team_lead.team_lead')}}" class="btn btn-primary mt-3">Go Back to Home</a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
