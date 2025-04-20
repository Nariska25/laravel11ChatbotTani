@extends('layouts.app')

@section('content')

<div class="profile-container" style="margin-top: 100px;">
    <div class="container" style="max-width: 1200px; margin-left: auto; margin-right: auto; padding-left: 1rem; padding-right: 1rem;">
        <div class="profile-flex">
            <!-- Left Sidebar -->
            <div class="profile-sidebar">
                <!-- Profile Card -->
                <div class="profile-card">
                    <div style="padding: 1.5rem; text-align: center;">
                        <div style="display: flex; justify-content: center; margin-bottom: 1rem;">
                            @if ($user->image_path)
                            <img src="{{ asset('storage/' . $user->image_path) }}" class="profile-img rounded-circle" alt="Profile Picture">
                        @else
                            <img src="{{ asset('assets/img/akun4.jpg') }}" class="profile-img rounded-circle" alt="Default Profile">
                        @endif
                        
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937;">{{ $user->name }}</h3>
                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">{{ $user->role ?? 'User' }}</p>
                        <a href="{{ route('profile.edit') }}" class="btn-success">
                            {{ $user->image_path ? 'Edit Profile Photo' : 'Add Profile Photo' }}
                        </a>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="profile-card">
                    <nav style="display: flex; flex-direction: column;">
                        <a href="{{ route('profile.show') }}" class="nav-item">
                            <i class="fas fa-user" style="margin-right: 0.75rem;"></i>
                            My Profile
                        </a>
                        <a href="{{ route('profile.alamat') }}" class="nav-item">
                            <i class="fas fa-map-marker-alt" style="margin-right: 0.75rem;"></i>
                            My Address
                        </a>
                        <a href="{{ route('profile.password') }}" class="nav-item active">
                            <i class="fas fa-lock" style="margin-right: 0.75rem;"></i>
                            Change Password
                        </a>
                    </nav>
                </div>
            </div>

             <!-- Password Change Form -->
             <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-4">
                            <i class="fas fa-key me-2"></i> Ubah Password
                        </h4>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('profile.updatepassword') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="current_password" class="form-label fw-bold">
                                    <i class="fas fa-lock me-1"></i> Password Saat Ini
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" 
                                           name="current_password" 
                                           required
                                           placeholder="Masukkan password saat ini">
                                    <span class="input-group-text toggle-password" data-target="current_password">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                    @error('current_password')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="new_password" class="form-label fw-bold">
                                    <i class="fas fa-key me-1"></i> Password Baru
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('new_password') is-invalid @enderror" 
                                           id="new_password" 
                                           name="new_password" 
                                           required
                                           placeholder="Masukkan password baru (min. 8 karakter)">
                                    <span class="input-group-text toggle-password" data-target="new_password">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                    @error('new_password')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <small class="text-muted">Gunakan kombinasi huruf besar, kecil, angka, dan simbol</small>
                            </div>

                            <div class="mb-4">
                                <label for="new_password_confirmation" class="form-label fw-bold">
                                    <i class="fas fa-key me-1"></i> Konfirmasi Password Baru
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                                           id="new_password_confirmation" 
                                           name="new_password_confirmation" 
                                           required
                                           placeholder="Ulangi password baru">
                                    <span class="input-group-text toggle-password" data-target="new_password_confirmation">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                    @error('new_password_confirmation')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-times me-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<style>
    .profile-container {
        background-color: #f9fafb;
        min-height: 100vh;
        padding: 2rem 0;
    }
    .profile-card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .profile-img {
        border-radius: 9999px;
        height: 8rem;
        width: 8rem;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }
    .nav-item {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .nav-item.active {
        color: white;
        background: linear-gradient(to right, #1a7e23, #198754);
    }
    .nav-item:hover:not(.active) {
        color: #111827;
        background-color: #f9fafb;
    }
    .info-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
    }
    .info-value {
        font-size: 0.875rem;
        color: #111827;
    }
    .btn-success {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background: linear-gradient(to right, #1a7e23, #198754);
        border: transparent;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .btn-success:hover {
        background: linear-gradient(to right, #1a7e23, #198754);
    }
    .btn-success {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background: linear-gradient(to right, #10b981, #0d9488);
        border: transparent;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .btn-success:hover {
        background: linear-gradient(to right, #059669, #0f766e);
    }
    @media (min-width: 768px) {
        .profile-flex {
            display: flex;
            flex-direction: row;
            gap: 1.5rem;
        }
        .profile-sidebar {
            width: 33.333333%;
        }
        .profile-content {
            width: 66.666667%;
        }
    }
</style>
@endsection


            