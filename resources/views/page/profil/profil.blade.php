@extends('layout.main')
@section('pages', 'Edit Profile || ' . Auth::user()->name)
@section('title', 'Edit Profile || ' . Auth::user()->name)

@section('content')
<div class="card">
    <div class="container-fluid py-4">

    <h2 class="text-center my-4">Edit Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $data->name) }}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username', $data->username) }}" required>
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @if ($data->role == 3)
                    <div class="form-group">
                    <label for="npwp">NPWP</label>
                    <input type="text" name="npwp" class="form-control" value="{{ old('npwp', $data->npwp) }}" required>
                    @error('npwp')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @else
                <div class="form-group">
                    <label for="no_pegawai">NIK</label>
                    <input type="text" name="no_pegawai" class="form-control" value="{{ old('no_pegawai', $data->no_pegawai) }}" required>
                    @error('no_pegawai')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $data->jabatan) }}" required>
                    @error('jabatan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $data->email) }}" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">New Password (optional)</label>
                    <input type="password" name="password" class="form-control" placeholder="Leave blank if not changing">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Leave blank if not changing">
                </div>

                <div class="form-group">
                    <label for="profile_image">Profile Image (optional)</label>
                    <input type="file" name="profile_image" class="form-control-file">
                    @if($data->profile)
                        <img src="{{asset('storage/user_profile/'.$data->id.'/'.$data->profile)}}" alt="Profile Image" class="img-thumbnail mt-2" width="150">
                    @endif
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block my-4">Update Profile</button>
    </form>
</div>
</div>
@endsection
