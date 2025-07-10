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

                <div class="mb-3">
                        <label for="password" class="form-label">New Password (optional) <small class="text-danger">*</small></label>
                        <input type="password" class="form-control" name="password" id="password">
                        <small>
                            
                            <ul class="form-text list-unstyled" id="password-hint">
                                <li id="hint-length" class="text-muted">• At least 8 characters</li>
                                <li id="hint-uppercase" class="text-muted">• At least 1 uppercase letter</li>
                                <li id="hint-lowercase" class="text-muted">• At least 1 lowercase letter</li>
                                <li id="hint-number" class="text-muted">• At least 1 number</li>
                                <li id="hint-symbol" class="text-muted">• At least 1 special character</li>
                            </ul>


                            <script>
                                const passwordInput = document.getElementById('password');

                                const hintLength = document.getElementById('hint-length');
                                const hintUpper = document.getElementById('hint-uppercase');
                                const hintLower = document.getElementById('hint-lowercase');
                                const hintNumber = document.getElementById('hint-number');
                                const hintSymbol = document.getElementById('hint-symbol');

                                passwordInput.addEventListener('input', function () {
                                    const value = passwordInput.value;

                                    // Cek setiap kriteria
                                    const isLongEnough = value.length >= 8;
                                    const hasUpper = /[A-Z]/.test(value);
                                    const hasLower = /[a-z]/.test(value);
                                    const hasNumber = /[0-9]/.test(value);
                                    const hasSymbol = /[^A-Za-z0-9]/.test(value);

                                    // Update masing-masing item
                                    updateHint(hintLength, isLongEnough);
                                    updateHint(hintUpper, hasUpper);
                                    updateHint(hintLower, hasLower);
                                    updateHint(hintNumber, hasNumber);
                                    updateHint(hintSymbol, hasSymbol);
                                });

                                function updateHint(element, condition) {
                                    if (condition) {
                                        element.classList.remove('text-muted');
                                        element.classList.add('text-success');
                                        element.innerHTML = element.innerHTML.replace('•', '✅');
                                    } else {
                                        element.classList.remove('text-success');
                                        element.classList.add('text-muted');
                                        element.innerHTML = element.innerHTML.replace('✅', '•');
                                    }
                                }
                            </script>



                        </small>
                        <span class="text-danger error-password"></span>
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
