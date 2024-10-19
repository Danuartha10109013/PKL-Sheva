@extends('layout.main')

@section('title', 'Edit Profile || ' . Auth::user()->name)

@section('content')
<div class="container">
    <h2>Edit Profile</h2>

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
            <label for="no_pegawai">Username</label>
            <input type="username" name="username" class="form-control" value="{{ old('username', $data->username) }}" required>
            @error('username')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <label for="no_pegawai">No Pegawai</label>
            <input type="no_pegawai" name="no_pegawai" class="form-control" value="{{ old('no_pegawai', $data->no_pegawai) }}" required>
            @error('no_pegawai')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <label for="jabatan">Jabatan</label>
            <input type="jabatan" name="jabatan" class="form-control" value="{{ old('jabatan', $data->jabatan) }}" required>
            @error('jabatan')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
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
            <input type="password" name="password" class="form-control">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="form-group">
            <label for="profile_image">Profile Image (optional)</label>
            <input type="file" name="profile_image" class="form-control-file">
            @if($data->profile)
                <img src="{{ Storage::url($data->profile) }}" alt="Profile Image" class="img-thumbnail" width="150">
            @endif
        </div>
        </div>
      </div>
        

        

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
