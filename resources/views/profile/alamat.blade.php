@extends('layouts.app')

@section('content')
<!-- Fallback CSS if Tailwind isn't working -->

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
                        <a href="{{ route('profile.alamat') }}" class="nav-item active">
                            <i class="fas fa-map-marker-alt" style="margin-right: 0.75rem;"></i>
                            My Address
                        </a>
                        <a href="{{ route('profile.password') }}" class="nav-item">
                            <i class="fas fa-lock" style="margin-right: 0.75rem;"></i>
                            Change Password
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Right Content -->
            <div class="profile-content">
                <div class="profile-card">
                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e5e7eb;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937;"> Address Information</h3>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <!-- Alamat -->
                            <div style="display: flex; flex-direction: column;">
                                <div>
                                    <label class="info-label">Alamat</label>
                                </div>
                                <div style="margin-top: 0.25rem;">
                                    <p class="info-value">{{ $user->address }}</p>
                                </div>
                            </div>
                           
                       
                            <!-- Kota -->
                            <div style="display: flex; flex-direction: column; border-top: 1px solid #f3f4f6; padding-top: 1rem;">
                                <div>
                                    <label class="info-label">Kota</label>
                                </div>
                                <div style="margin-top: 0.25rem;">
                                    <p class="info-value">{{ $user->city }}</p>
                                </div>
                            </div>
                            
                            <!-- Kode Pos -->
                            <div style="display: flex; flex-direction: column; border-top: 1px solid #f3f4f6; padding-top: 1rem;">
                                <div>
                                    <label class="info-label">Kode Pos</label>
                                </div>
                                <div style="margin-top: 0.25rem;">
                                    <p class="info-value">{{ $user->postal_code }}</p>
                                </div>
                            </div>
                            
                            <!-- Gender -->
                            <div style="display: flex; flex-direction: column; border-top: 1px solid #f3f4f6; padding-top: 1rem;">
                                <div>
                                    <label class="info-label">Provinsi</label>
                                </div>
                                <div style="margin-top: 0.25rem;">
                                    <p class="info-value">{{ $user->province }}</p>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
                            <a href="{{ route('profile.editalamat') }}" class="btn-success">
                                Edit Alamat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
