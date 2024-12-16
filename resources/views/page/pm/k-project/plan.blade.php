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
            <h6 class="mb-2">Detail Of Project Plan No Dokumen : {{$data->no_projec_plan}}</h6>
            
        </div>
        <P>No Revisi : {{$data->no_rev}}</P>
    </div>
    <div class="card-body">
        <p>This is the Project plan. Download the guide for filling it out:
            <a href="{{ route('pm.download', 'PROJECT PLAN - TEMPLATE.docx') }}" class="text-green" style="color: green">Click Here For Download</a>
        </p>
        
        
        <!-- Form for editing project plan -->
        @if ($data->status == 2)
        <form action="{{ route('pm.k-project.plan.update.revision', $id) }}" method="POST">
        @else
        <form action="{{ route('pm.k-project.plan.update', $id) }}" enctype="multipart/form-data" method="POST">
        @endif
            @csrf
            @method('PUT')
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button><small class="text-danger">*</small> save first before generating

            
            <div class="mb-3">
                <label for="pengantar">Pengantar</label>
                <textarea name="pengantar" id="pengantar" class="form-control" cols="30" rows="10">{{ old('pengantar', $data->pengantar) }}</textarea>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button><small class="text-danger">*</small> save first before generating

            
            <div class="mb-3">
                <label for="ringkasan">Ringkasan</label>
                <textarea name="ringkasan" id="ringkasan" class="form-control" cols="30" rows="10">{{ old('ringkasan', $data->ringkasan) }}</textarea>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button><small class="text-danger">*</small> save first before generating

            
            <div class="mb-3">
                <label for="ruang_lingkup">Ruang Lingkup</label>
                <textarea name="ruang_lingkup" id="ruang_lingkup" class="form-control" cols="30" rows="10">{{ old('ruang_lingkup', $data->ruang_lingkup) }}</textarea>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button><small class="text-danger">*</small> save first before generating

            
            <div class="mb-3">
                <label for="jadwal_proyek">Jadwal Proyek</label>
                <textarea name="jadwal_proyek" id="jadwal_proyek" class="form-control" cols="30" rows="10">{{ old('jadwal_proyek', $data->jadwal_proyek) }}</textarea>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button><small class="text-danger">*</small> save first before generating

            
            <div id="dynamic-form-container">
                @if(!empty($fase))
                    @foreach($fase as $index => $item)
                        <div class="mb-3 dynamic-input">
                            <label for="fase_{{ $index + 1 }}">Fase {{ $index + 1 }}</label>
                            <input type="text" name="scrum_name[]" value="{{ $item['scrum_name'] }}" placeholder="Fase {{ $index + 1 }}">
                            <input type="date" name="start[]" value="{{ $item['start'] }}">
                            <input type="date" name="end[]" value="{{ $item['end'] }}">
                            <textarea name="fase_1[]" id="fase_{{ $index + 1 }}" class="form-control ck-editor" cols="30" rows="3" placeholder="Fase {{ $index + 1 }}">{{ $item['description'] }}</textarea>
                            <button type="button" class="btn btn-danger btn-sm remove-input" onclick="removeInput(this)">Hapus</button>
                        </div>
                    @endforeach
                @else
                    <div class="mb-3 dynamic-input">
                        <label for="fase_1">Fase 1</label>
                        <input type="text" name="scrum_name[]" placeholder="Fase 1">
                        <input type="date" name="start[]">
                        <input type="date" name="end[]">
                        <textarea name="fase_1[]" id="fase_1" class="form-control ck-editor" cols="30" rows="3" placeholder="Fase 1"></textarea>
                        <button type="button" class="btn btn-danger btn-sm remove-input" onclick="removeInput(this)">Hapus</button>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-primary btn-sm" onclick="addInput()">Tambah Fase</button>
            
            <script>
                let phaseCounter = {{ !empty($fase) ? count($fase) + 1 : 2 }}; // Mulai dari fase berikutnya
            
                // Inisialisasi CKEditor untuk semua textarea yang ada saat halaman dimuat
                document.addEventListener('DOMContentLoaded', () => {
                    const textareas = document.querySelectorAll('.ck-editor');
                    textareas.forEach(textarea => {
                        if (!CKEDITOR.instances[textarea.id]) {
                            CKEDITOR.replace(textarea.id);
                        }
                    });
                });
            
                // Fungsi untuk menambah input baru
                function addInput() {
                    const container = document.getElementById('dynamic-form-container');
                    const newInput = document.createElement('div');
                    newInput.classList.add('mb-3', 'dynamic-input');
            
                    const uniqueId = `fase_${phaseCounter}`;
            
                    newInput.innerHTML = `
                        <label for="${uniqueId}">Fase ${phaseCounter}</label>
                        <input type="text" name="scrum_name[]" placeholder="Fase ${phaseCounter}">
                        <input type="date" name="start[]">
                        <input type="date" name="end[]">
                        <textarea name="fase_1[]" id="${uniqueId}" class="form-control ck-editor" cols="30" rows="3" placeholder="Fase ${phaseCounter}"></textarea>
                        <button type="button" class="btn btn-danger btn-sm remove-input" onclick="removeInput(this)">Hapus</button>
                    `;
                    container.appendChild(newInput);
            
                    // Inisialisasi CKEditor untuk textarea baru
                    CKEDITOR.replace(uniqueId);
            
                    phaseCounter++;
                }
            
                // Fungsi untuk menghapus input
                function removeInput(button) {
                    const parent = button.parentElement;
            
                    // Hapus instance CKEditor sebelum menghapus elemen
                    const textarea = parent.querySelector('textarea');
                    if (textarea && CKEDITOR.instances[textarea.id]) {
                        CKEDITOR.instances[textarea.id].destroy();
                    }
            
                    parent.remove();
                }
            </script>
            
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button><small class="text-danger">*</small> save first before generating

            
            <div class="mb-3">
                <label for="team_proyek">Tim Proyek</label>
                <textarea name="team_proyek" id="team_proyek" class="form-control" cols="30" rows="10">{{ old('team_proyek', $data->team_proyek) }}</textarea>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button><small class="text-danger">*</small> save first before generating

            
            <div class="mb-3">
                <label for="manajemen_proyek">Fitur Utama Aplikasi Resiko</label>
                <textarea name="manajemen_proyek" id="manajemen_proyek" class="form-control" cols="30" rows="10">{{ old('manajemen_proyek', $data->manajemen_proyek) }}</textarea>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button><small class="text-danger">*</small> save first before generating

            
            <div class="mb-3">
                <label for="fitur_utama">Fitur Utama Aplikasi</label>
                <textarea name="fitur_utama" id="fitur_utama" class="form-control" cols="30" rows="10">{{ old('fitur_utama', $data->fitur_utama) }}</textarea>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button><small class="text-danger">*</small> save first before generating

            
            <div class="mb-3">
                <label for="rincian_teknis">Rincian Teknis & Tugas</label>
                <textarea name="rincian_teknis" id="rincian_teknis" class="form-control" cols="30" rows="10">{{ old('rincian_teknis', $data->rincian_teknis) }}</textarea>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button><small class="text-danger">*</small> save first before generating

            
            <div class="mb-3">
                <label for="topologi">Topologi Microservices Cloud Server dengan AWS</label>
                <textarea name="topologi" id="topologi" class="form-control" cols="30" rows="10">{{ old('topologi', $data->topologi) }}</textarea>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button><small class="text-danger">*</small> save first before generating

            
            <div class="mb-3">
                <label for="diagram">Diagram Arsitektur</label>
                <textarea name="diagram" id="diagram" class="form-control" cols="30" rows="10">{{ old('diagram', $data->diagram) }}</textarea>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button><small class="text-danger">*</small> save first before generating

            
            <div class="mb-3">
                <label for="anggaran">Anggaran Pengerjaan</label>
                <textarea name="anggaran" id="anggaran" class="form-control" cols="30" rows="10">{{ old('anggaran', $data->anggaran) }}</textarea>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button><small class="text-danger">*</small> save first before generating

            
            <div class="mb-3">
                <label for="nilai">Nilai Proyek</label>
                <textarea name="nilai" id="nilai" class="form-control" cols="30" rows="10">{{ old('nilai', $data->nilai) }}</textarea>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button><small class="text-danger">*</small> save first before generating

            
            <div class="mb-3">
                <label for="pernyataan">Pernyataan Kesepakatan Dokumen Perencanaan Proyek</label>
                <textarea name="pernyataan" id="pernyataan" class="form-control" cols="30" rows="10">{{ old('pernyataan', $data->pernyataan) }}</textarea>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Generate Image Link
            </button> <small class="text-danger">*</small> save first before generating

            
            <div class="mb-3">
                <label for="catatan">Catatan Tambahan</label>
                <textarea name="catatan" id="catatan" class="form-control" cols="30" rows="10">{{ old('catatan', $data->catatan) }}</textarea>
            </div>

            <!-- Submit button -->
            <a href="{{route('pm.k-project')}}"" class="btn btn-secondary">Back</a>
            @if ($data->status == 2)
            <button type="submit" class="btn btn-primary">Save Revision</button>
            @else
            <button type="submit" class="btn btn-primary">Save</button>
            @endif
        </form>
        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Upload Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('page.pm.k-project.generate')
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<!-- CKEditor Script -->
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    const textareas = [
        'pengantar', 'ringkasan', 'ruang_lingkup', 'jadwal_proyek', 
        'fase_1', 'team_proyek', 'manajemen_proyek', 'fitur_utama', 
        'rincian_teknis', 'topologi', 'diagram', 'anggaran', 
        'nilai', 'pernyataan', 'catatan'
    ];

    textareas.forEach(function(id) {
        CKEDITOR.replace(id)
    });
</script>



@endsection
