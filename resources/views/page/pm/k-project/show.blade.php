@extends('layout.main')
@section('title')
Detail Project Plan || {{ Auth::user()->name }}
@endsection
@section('pages')
Detail Project Plan
@endsection
@section('content')
<div class="card">
    <div class="card-header pb-0">
        <div class="d-flex justify-content-between">
            <h6 class="">Detail Of Project Plan</h6>
            <a href="{{route('pm.k-project.print',$project->id)}}" class="btn btn-primary"><i class="fa fa-download"></i></a>
        </div>
    </div>
    <div class="card-body">
        <h3>{!! $project->judul !!}</h3>
        <p class="mt-3"><strong>Pengantar</strong></p>
        {!! $data->pengantar !!}
        <p class="mt-3"><strong>Ringkasan Eksekutif</strong></p>
        {!! $data->ringkasan !!}
        <p class="mt-3"><strong>Ruang Lingkup Proyek</strong></p>
        {!! $data->ruang_lingkup !!}
        <p class="mt-3"><strong>Jadwal Proyek</strong></p>
        {!! $data->jadwal_proyek !!}
        <p class="mt-3"><strong>Fase 1</strong></p>
        {!! $data->fase_1 !!}
        <p class="mt-3"><strong>Tim Proyek</strong></p>
        {!! $data->team_proyek !!}
        <p class="mt-3"><strong>Manajemen Risiko</strong></p>
        {!! $data->manajemen_proyek !!}
        <p class="mt-3"><strong>Fitur Utama Aplikasi</strong></p>
        {!! $data->fitur_utama !!}
        <p class="mt-3"><strong>Rincian Teknis & Tugas</strong></p>
        {!! $data->rincian_teknis !!}
        <p class="mt-3"><strong>Topologi Microservices Cloud Server dengan AWS</strong></p>
        {!! $data->topologi !!}
        <p class="mt-3"><strong>Diagram Arsitektur</strong></p>
        {!! $data->diagram !!}
        <p class="mt-3"><strong>Anggaran Pengerjaan</strong></p>
        {!! $data->anggaran !!}
        <p class="mt-3"><strong>Nilai Proyek</strong></p>
        {!! $data->nilai !!}
        <p class="mt-3"><strong>Pernyataan Kesepakatan Dokumen Perencanaan Proyek</strong></p>
        {!! $data->pernyataan !!}
        <p class="mt-3"><strong>Catatan Tambahan:</strong></p>
        {!! $data->catatan !!}
    </div>
</div>
@endsection