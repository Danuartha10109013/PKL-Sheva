@extends('layout.main')
@section('title')
Kelola User || {{Auth::user()->name}}
@endsection
@section('pages')
Kelola User
@endsection
@section('content')

<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fa fa-user-plus"> Add new User</i></a>

<div class="card">
    <div class="card-header pb-0 p-3">
        <div class="d-flex justify-content-between">
            <h6 class="mb-2">List Of User</h6>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-items-center">
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td class="w-30">
                        <div class="d-flex px-2 py-1 align-items-center">
                            <div>
                                <img src="{{asset('storage/user_profile/'.$d->id.'/'.$d->profile)}}" width="50px" alt="Img">
                            </div>
                            <div class="ms-4">
                                <p class="text-xs font-weight-bold mb-0">Name:</p>
                                <h6 class="text-sm mb-0">{{$d->name}}</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-left">
                            <p class="text-xs font-weight-bold mb-0">Employee No:</p>
                            <h6 class="text-sm mb-0">{{$d->no_pegawai}}</h6>
                        </div>
                    </td>
                    <td>
                        <div class="text-left">
                            <p class="text-xs font-weight-bold mb-0">Position:</p>
                            <h6 class="text-sm mb-0">{{$d->jabatan}}</h6>
                        </div>
                    </td>
                    <td class="align-middle text-sm">
                        <div class="col text-left">
                            <p class="text-xs font-weight-bold mb-0">Role:</p>
                            <h6 class="text-sm mb-0">{{$d->role == 0 ? "Project Manager" : ($d->role == 1 ? "Team Leader" : ($d->role == 2 ? "Finance" : "Client"))}}</h6>
                        </div>
                    </td>
                    <td class="align-middle text-sm">
                        <div class="col text-left">
                            <p class="text-xs font-weight-bold mb-0">Action:</p>
                            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#showUserModal{{ $d->id }}"><i class="fa fa-eye"></i> </a>
                            <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{$d->id}}"><i class="fa fa-pencil-square"></i></a>
                            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{$d->id}}"><i class="fa fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('pm.k-user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_pegawai" class="form-label">Employee Number</label>
                        <input type="text" class="form-control" name="no_pegawai" id="no_pegawai" required>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Position</label>
                        <input type="text" class="form-control" name="jabatan" id="jabatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Address (Optional)</label>
                        <input type="text" class="form-control" name="alamat" id="alamat">
                    </div>
                    <div class="mb-3">
                        <label for="active" class="form-label">Active Status</label>
                        <select class="form-select" name="active" id="active" required>
                            <option value="" selected disabled>--Select Status--</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" name="role" id="role" required>
                            <option value="" selected disabled>--Select Role--</option>
                            <option value="0">Project Manager</option>
                            <option value="1">Team Leader</option>
                            <option value="2">Finance</option>
                            <option value="3">Client</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="birthday" class="form-label">Birthday (Optional)</label>
                        <input type="date" class="form-control" name="birthday" id="birthday">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="profile" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" name="profile" id="profile">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required minlength="8">
                        <small class="form-text text-muted">Minimum 8 characters</small>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
@foreach($data as $d)

<div class="modal fade" id="showUserModal{{ $d->id }}" tabindex="-1" aria-labelledby="showUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);">
            <div class="modal-body p-4" style="background: linear-gradient(135deg, #f3f4f6, #e5e7eb); border-radius: 10px;">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="modal-title text-primary" id="showUserModalLabel">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card mt-3 p-3" style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <div class="text-center mb-3">
                        <img src="{{ $d->profile ? asset('storage/user_profile/' . $d->id . '/' . $d->profile) : asset('images/default_profile.png') }}" 
                             alt="User Profile Image" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #4b5563;">
                    </div>
                    <div class="card-body text-center">
                        <h4 class="card-title text-dark">{{ $d->name }}</h4>
                        <p class="card-subtitle text-muted">{{ $d->jabatan }}</p>
                        <p class="mt-2">
                            <span class="badge bg-primary">{{ $d->role == 0 ? 'Project Manager' : ($d->role == 1 ? 'Team Leader' : ($d->role == 2 ? 'Finance' : 'Client')) }}</span>
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <h6 class="text-primary mb-3">Contact Information</h6>
                    <p><strong>Email:</strong> {{ $d->email }}</p>
                    <p><strong>Employee No:</strong> {{ $d->no_pegawai }}</p>
                    <p><strong>Birthday:</strong> {{ $d->birthday }}</p>
                    <p><strong>Address:</strong> {{ $d->alamat ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> <span class="badge {{ $d->active ? 'bg-success' : 'bg-danger' }}">{{ $d->active ? 'Active' : 'Inactive' }}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editUserModal{{$d->id}}" tabindex="-1" aria-labelledby="editUserModalLabel{{$d->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('pm.k-user.update', $d->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel{{$d->id}}">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $d->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" value="{{ $d->username }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ $d->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" name="role" id="role" 
                               value="{{ $d->role == 0 ? 'Project Manager' : ($d->role == 1 ? 'Team Leader' : ($d->role == 2 ? 'Finance' : 'Client')) }}" 
                               readonly>
                    </div>
                    <div class="mb-3">
                        <label for="profile" class="form-label">New Profile (optional)</label>
                        <input type="file" class="form-control" name="profile" id="profile">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password (optional)</label>
                        <input type="password" class="form-control" name="password" id="password" minlength="8">
                        <small class="form-text text-muted">Minimum 8 characters</small>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Password Confirmation</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" minlength="8">
                    </div>
                    <!-- Add other fields as needed -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Update User</button>
                </div>
            </div>
        </form>
        
    </div>
</div>
@endforeach

<!-- Delete Confirmation Modal -->
@foreach($data as $d)
<div class="modal fade" id="deleteUserModal{{$d->id}}" tabindex="-1" aria-labelledby="deleteUserModalLabel{{$d->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('pm.k-user.destroy', $d->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel{{$d->id}}">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete user <strong>{{ $d->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection
