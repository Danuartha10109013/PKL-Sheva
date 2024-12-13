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
            <a href="" class="btn btn-primary"><i class="fa fa-download"></i></a>
        </div>
    </div>
    <div class="card-body">
        <h3>{!! $project->judul !!}</h3>
        <div class="row">
            <div class="col-md-8">
                <p class="mt-3"><strong>Pengantar</strong></p>
                {!! $data->pengantar !!}
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan Customer</strong></p>
                <div class="btn btn-light">
                    {{ $data->pengantar_catatan }}
                </div>
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan TL</strong></p>
                <div class="btn btn-light">
                    {{ $data->pengantar_catatantl }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p class="mt-3"><strong>Ringkasan Eksekutif</strong></p>
                {!! $data->ringkasan !!}
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->ringkasan_catatan }}
                </div>
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->ringkasan_catatantl }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p class="mt-3"><strong>Ruang Lingkup Proyek</strong></p>
                {!! $data->ruang_lingkup !!}
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->ruang_lingkup_catatan }}
                </div>
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->ruang_lingkup_catatantl }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p class="mt-3"><strong>Jadwal Proyek</strong></p>
                {!! $data->jadwal_proyek !!}
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->jadwal_proyek_catatan }}
                </div>
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->jadwal_proyek_catatantl }}
                </div>
            </div>
        </div>
        <div class="row">
            @php
                $fase = json_decode($data->fase);
            @endphp
            @foreach ($fase as $f)
                
                <div class="col-md-8">
                    <p class="mt-3"><strong>{{$f->scrum_name}} , {{$f->start}} sampai {{$f->end}}</strong></p>
                    {!! $f->description !!}
                </div>
                <div class="col-md-2">
                    <p class="mt-3"><strong>Catatan</strong></p>
                    <div class="btn btn-light">
                        {{ $f->note }}
                    </div>
                </div>
                <div class="col-md-2">
                    <p class="mt-3"><strong>Catatan</strong></p>
                    <div class="btn btn-light">
                        {{ $data->fase_1_catatantl }}
                    </div>
                </div>
            @endforeach

        </div>
        <div class="row">
            <div class="col-md-8">
                <p class="mt-3"><strong>Tim Proyek</strong></p>
            {!! $data->team_proyek !!}
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->team_proyek_catatan }}
                </div>
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->team_proyek_catatantl }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p class="mt-3"><strong>Manajemen Risiko</strong></p>
                {!! $data->manajemen_proyek !!}
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->manajemen_proyek_catatan }}
                </div>
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->manajemen_proyek_catatantl }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p class="mt-3"><strong>Fitur Utama Aplikasi</strong></p>
                {!! $data->fitur_utama !!}
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->fitur_utama_catatan }}
                </div>
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->fitur_utama_catatantl }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p class="mt-3"><strong>Rincian Teknis & Tugas</strong></p>
                {!! $data->rincian_teknis !!}
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->rincian_teknis_catatan }}
                </div>
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->rincian_teknis_catatantl }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p class="mt-3"><strong>Topologi Microservices Cloud Server dengan AWS</strong></p>
                {!! $data->topologi !!}
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->topologi_catatan }}
                </div>
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->topologi_catatantl }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p class="mt-3"><strong>Diagram Arsitektur</strong></p>
                {!! $data->diagram !!}
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->diagram_catatan }}
                </div>
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->diagram_catatantl }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p class="mt-3"><strong>Anggaran Pengerjaan</strong></p>
                {!! $data->anggaran !!}
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->anggaran_catatan }}
                </div>
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->anggaran_catatantl }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p class="mt-3"><strong>Nilai Proyek</strong></p>
                {!! $data->nilai !!}
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->nilai_catatan }}
                </div>
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->nilai_catatantl }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p class="mt-3"><strong>Pernyataan Kesepakatan Dokumen Perencanaan Proyek</strong></p>
                {!! $data->pernyataan !!}
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->pernyataan_catatan }}
                </div>
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->pernyataan_catatantl }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p class="mt-3"><strong>Catatan Tambahan:</strong></p>
                {!! $data->catatan !!}
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->catatan_catatan }}
                </div>
            </div>
            <div class="col-md-2">
                <p class="mt-3"><strong>Catatan</strong></p>
                <div class="btn btn-light">
                    {{ $data->catatan_catatantl }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
