@extends('layout.main')
@section('title')
Detail Project Plan || {{ Auth::user()->name }}
@endsection
@section('pages')
Detail Project Plan
@endsection
@section('content')
<div class="card">
    <div class="card-header pb-0 p-3">
        <div class="d-flex justify-content-between">
            <h6 class="mb-2">Detail Of Project Plan</h6>
        </div>
    </div>
    <div class="card-body">
        <p>This is the Project plan. Download the guide for filling it out:
            <a href="{{ route('pm.download', 'PROJECT PLAN - TEMPLATE.docx') }}" class="text-green" style="color: green">Click Here For Download</a>
        </p>
        
        <!-- Form for editing project plan -->
        @if ($data->status == 2)
        <form action="{{ route('pm.k-project.plan.update.revision', $id) }}" method="POST">
        @else
        <form action="{{ route('pm.k-project.plan.update', $id) }}" method="POST">
        @endif
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="pengantar">Pengantar</label>
                <textarea name="pengantar" id="pengantar" class="form-control" cols="30" rows="10">{{ old('pengantar', $data->pengantar) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="ringkasan">Ringkasan</label>
                <textarea name="ringkasan" id="ringkasan" class="form-control" cols="30" rows="10">{{ old('ringkasan', $data->ringkasan) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="ruang_lingkup">Ruang Lingkup</label>
                <textarea name="ruang_lingkup" id="ruang_lingkup" class="form-control" cols="30" rows="10">{{ old('ruang_lingkup', $data->ruang_lingkup) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="jadwal_proyek">Jadwal Proyek</label>
                <textarea name="jadwal_proyek" id="jadwal_proyek" class="form-control" cols="30" rows="10">{{ old('jadwal_proyek', $data->jadwal_proyek) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="fase_1">Fase 1</label>
                <textarea name="fase_1" id="fase_1" class="form-control" cols="30" rows="10">{{ old('fase_1', $data->fase_1) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="team_proyek">Tim Proyek</label>
                <textarea name="team_proyek" id="team_proyek" class="form-control" cols="30" rows="10">{{ old('team_proyek', $data->team_proyek) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="manajemen_proyek">Fitur Utama Aplikasi Resiko</label>
                <textarea name="manajemen_proyek" id="manajemen_proyek" class="form-control" cols="30" rows="10">{{ old('manajemen_proyek', $data->manajemen_proyek) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="fitur_utama">Fitur Utama Aplikasi</label>
                <textarea name="fitur_utama" id="fitur_utama" class="form-control" cols="30" rows="10">{{ old('fitur_utama', $data->fitur_utama) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="rincian_teknis">Rincian Teknis & Tugas</label>
                <textarea name="rincian_teknis" id="rincian_teknis" class="form-control" cols="30" rows="10">{{ old('rincian_teknis', $data->rincian_teknis) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="topologi">Topologi Microservices Cloud Server dengan AWS</label>
                <textarea name="topologi" id="topologi" class="form-control" cols="30" rows="10">{{ old('topologi', $data->topologi) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="diagram">Diagram Arsitektur</label>
                <textarea name="diagram" id="diagram" class="form-control" cols="30" rows="10">{{ old('diagram', $data->diagram) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="anggaran">Anggaran Pengerjaan</label>
                <textarea name="anggaran" id="anggaran" class="form-control" cols="30" rows="10">{{ old('anggaran', $data->anggaran) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="nilai">Nilai Proyek</label>
                <textarea name="nilai" id="nilai" class="form-control" cols="30" rows="10">{{ old('nilai', $data->nilai) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="pernyataan">Pernyataan Kesepakatan Dokumen Perencanaan Proyek</label>
                <textarea name="pernyataan" id="pernyataan" class="form-control" cols="30" rows="10">{{ old('pernyataan', $data->pernyataan) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="catatan">Catatan Tambahan</label>
                <textarea name="catatan" id="catatan" class="form-control" cols="30" rows="10">{{ old('catatan', $data->catatan) }}</textarea>
            </div>

            <!-- Submit button -->
            @if ($data->status == 2)
            <button type="submit" class="btn btn-primary">Save Revision</button>
            @else
            <button type="submit" class="btn btn-primary">Save</button>
            @endif
        </form>
    </div>
</div>

<!-- CKEditor Script -->
<script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
<script>
    // Initialize CKEditor
    CKEDITOR.replace('pengantar');
    CKEDITOR.replace('ringkasan');
    CKEDITOR.replace('ruang_lingkup');
    CKEDITOR.replace('jadwal_proyek');
    CKEDITOR.replace('fase_1');
    CKEDITOR.replace('team_proyek');
    CKEDITOR.replace('manajemen_proyek');
    CKEDITOR.replace('fitur_utama');
    CKEDITOR.replace('rincian_teknis');
    CKEDITOR.replace('topologi');
    CKEDITOR.replace('diagram');
    CKEDITOR.replace('anggaran');
    CKEDITOR.replace('nilai');
    CKEDITOR.replace('pernyataan');
    CKEDITOR.replace('catatan');
</script>
@endsection
