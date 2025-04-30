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
              {{-- Cari nama customer berdasarkan ID --}}
              {{ $customer->where('id', $d->customer_id)->pluck('name')->first() ?? 'N/A' }}
          </td>
          <td> &nbsp;&nbsp;&nbsp;&nbsp;
              {{-- Cari nama team leader berdasarkan ID --}}
              {{ $team_leader->where('id', $d->team_leader_id)->pluck('name')->first() ?? 'N/A' }}
          </td>
          <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$d->start}}</td>
          <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$d->end}}</td>
          <td> &nbsp;&nbsp;&nbsp;&nbsp;
              {{-- Mengambil project plan ID --}}
              @php
                  $plans = \App\Models\ProjectPlanM::where('project_id', $d->id)->first();
              @endphp
              <a href="{{ route('pm.k-project.show', $d->id) }}" class="btn btn-success">
                  <i class="fa fa-eye"></i>
              </a>
  
                {{-- @if ($d->launch != 1) --}}
                    <a href="{{ route('pm.k-project.plan', $plans->id) }}" class="btn btn-primary">
                        <i class="fas fa-keyboard"></i>
                    </a>
                {{-- @endif --}}
                  <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{$d->id}}">
                      <i class="fa fa-pencil-square"></i>
                  </a>
                  <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$d->id}}">
                      <i class="fa fa-trash"></i>
                  </a>
  
              @if ($d->launch == 0)
                  <a class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#launchConfirmModal{{$d->id}}">
                      <i class="fa fa-rocket"></i>
                  </a>
              @else
                  <a href="{{ route('pm.k-project.communication', $d->id) }}" class="btn btn-light">
                      <i class="fa-solid fa-people-arrows"></i>
                  </a>
                  @php
                    $planss = \App\Models\ProjectPlanM::where('project_id',$d->id)->value('status');
                  @endphp
                  @if ($planss != 1)
                  <a href="#" data-id="{{ $d->id }}" class="btn btn-primary" id="approveBtn">
                      <i class="fa-solid fa-key"></i>
                  </a>
                  @endif
                  <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="confirmationModalLabel">Confirm Approval</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to Lock the project plan?
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
                        const url = '{{ route("pm.k-project.setuju", ":id") }}'.replace(':id', projectId);
                  
                        // Set the href of the confirm button to the approval route
                        confirmBtn.setAttribute('href', url);
                  
                        // Show the modal
                        modal.show();
                      });
                    });
                  </script>

              @endif
          </td>
          <td> &nbsp;&nbsp;&nbsp;&nbsp;Rp. {{$d->biaya}}</td>
      </tr>
  
      <!-- Launch Confirmation Modal -->
      <div class="modal fade" id="launchConfirmModal{{$d->id}}" tabindex="-1" aria-labelledby="launchConfirmModalLabel{{$d->id}}" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="launchConfirmModalLabel{{$d->id}}">Confirm Launch</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      Are you sure you want to launch this project to the customer?
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <a href="{{ route('pm.k-project.launch', $d->id) }}" class="btn btn-dark">Yes, Launch</a>
                  </div>
              </div>
          </div>
      </div>

        <!-- Edit Modal for Each Row -->
        <div class="modal fade" id="editModal{{$d->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$d->id}}" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="{{ route('pm.k-project.update', $d->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel{{$d->id}}">Edit Data</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="judul{{$d->id}}" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="judul{{$d->id}}" name="judul" value="{{ $d->judul }}">
                  </div>
                  <div class="mb-3">
                    <label for="start{{$d->id}}" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start{{$d->id}}" name="start" value="{{ $d->start }}">
                  </div>
                  <div class="mb-3">
                    <label for="end{{$d->id}}" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end{{$d->id}}" name="end" value="{{ $d->end }}">
                  </div>
                  <div class="mb-3">
                    <label for="biaya{{$d->id}}" class="form-label">Total Biaya</label>
                    <input type="text" class="form-control" id="biaya{{$d->id}}" name="biaya" value="{{ $d->biaya }}">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Delete Modal for Each Row -->
        <div class="modal fade" id="deleteModal{{$d->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$d->id}}" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="{{ route('pm.k-project.delete', $d->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteModalLabel{{$d->id}}">Confirm Delete</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Are you sure you want to delete this record?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-danger">Delete</button>
                </div>
              </form>
            </div>
          </div>
        </div>

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
                        <label for="customer" class="form-label">Team Lead</label>
                        <select type="text" class="form-control" id="customer" name="team_leader" required>
                            <option value="" selected disabled>--Pilih Team Lead Or Add New</option>
                            @foreach ($team_leader as $tl)
                            <option value="{{$tl->id}}" >{{$tl->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start" name="start" >
                    </div>
                    <div class="mb-3">
                        <label for="end" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end" name="end" >
                    </div>
                    <div class="mb-3">
                      <label for="biaya" class="form-label">Total Cost</label>
                      <input type="text" class="form-control" id="biaya" name="biaya_display">
                      <input type="hidden" id="biaya_hidden" name="biaya">
                  </div>
                  <script>
                    const inputDisplay = document.getElementById('biaya');
                    const inputHidden = document.getElementById('biaya_hidden');
                    
                    inputDisplay.addEventListener('input', function(e) {
                        let value = this.value.replace(/[^0-9]/g, ''); // ambil hanya angka
                        let formatted = new Intl.NumberFormat('id-ID').format(value); // format pakai titik
                    
                        this.value = 'Rp ' + formatted;
                        inputHidden.value = value; // hanya angka, tanpa Rp dan titik
                    });
                    </script>
                                      
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