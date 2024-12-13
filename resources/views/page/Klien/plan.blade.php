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
        <div class="d-flex justify-content-between align-items-center">
            <h6>Detail of Project Plan</h6>
          @if ($project->launch == 1)
          <a href="" class="btn btn-primary"><i class="fa fa-download"></i> Download</a>
          @endif
        </div>
    </div>
    @if (Auth::user()->role == 3)
    <form action="{{ route('klien.project.update', $data->id) }}" method="POST">
    @else
    <form action="{{ route('team_lead.project.update', $data->id) }}" method="POST">
    @endif
        @csrf
        <div class="card-body">
          @if ($project->launch == 1)
            <h3 class="mb-4">{{ $project->judul }}</h3>
              
            @foreach ($sections as $section)
                <div class="row mb-4">
                    <div class="col-md-9">
                        <p class="font-weight-bold">{{ $section['title'] }}</p>
                        <div class="border p-3 bg-light">
                            {!! $section['content'] !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p class="font-weight-bold">Catatan</p>
                        @if ($data->status == 1)
                        <textarea name="{{ $section['name'] }}" class="form-control" rows="4" readonly>{{ old($section['name'], $section['note']) }}</textarea>
                        @else
                        <textarea name="{{ $section['name'] }}" class="form-control" rows="4">{{ old($section['name'], $section['note']) }}</textarea>
                        @endif
                    </div>
                </div>
            @endforeach
            <div class="text-end">
              @if ($data->status == 1)
              @else
              <button type="submit" class="btn btn-success">Save Changes</button>
              @endif
            </div>
          </div>
        </form>
            @if (Auth::user()->role == 3)
              @if ($data->status == 1)
              @else
                <a href="#" data-id="{{ $data->id }}" class="btn btn-primary" id="approveBtn"><i class="fa fa-check"></i> Approve Project Plan</a>
              @endif
            @endif
        @else
        <p class="text-center text-warning">The Document is in Progres</p>
        @endif
            

            


    <!-- Approve Project Plan Button -->

    <!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModalLabel">Confirm Approval</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to approve the project plan?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <a id="confirmBtn" href="#" class="btn btn-primary">Approve</a>
        </div>
      </div>
    </div>
  </div>
  
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
      const approveBtn = document.getElementById('approveBtn');
      const confirmBtn = document.getElementById('confirmBtn');
      const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
  
      approveBtn.addEventListener('click', function (e) {
        e.preventDefault();
        const projectId = approveBtn.getAttribute('data-id');
        const url = '{{ route("klien.project.setuju", ":id") }}'.replace(':id', projectId);
  
        // Set the href of the confirm button to the approval route
        confirmBtn.setAttribute('href', url);
  
        // Show the modal
        modal.show();
      });
    });
  </script>
  
@endsection
