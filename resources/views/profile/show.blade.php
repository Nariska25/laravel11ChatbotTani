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
                        <a href="{{ route('profile.show') }}" class="nav-item active">
                            <i class="fas fa-user" style="margin-right: 0.75rem;"></i>
                            My Profile
                        </a>
                        <a href="{{ route('profile.alamat') }}" class="nav-item">
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
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937;">Profile Information</h3>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <!-- Name -->
                            <div style="display: flex; flex-direction: column;">
                                <div>
                                    <label class="info-label">Full Name</label>
                                </div>
                                <div style="margin-top: 0.25rem;">
                                    <p class="info-value">{{ $user->name }}</p>
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div style="display: flex; flex-direction: column; border-top: 1px solid #f3f4f6; padding-top: 1rem;">
                                <div>
                                    <label class="info-label">Email</label>
                                </div>
                                <div style="margin-top: 0.25rem;">
                                    <p class="info-value">{{ $user->email }}</p>
                                </div>
                            </div>
                            
                            <!-- Phone -->
                            <div style="display: flex; flex-direction: column; border-top: 1px solid #f3f4f6; padding-top: 1rem;">
                                <div>
                                    <label class="info-label">Phone</label>
                                </div>
                                <div style="margin-top: 0.25rem;">
                                    <p class="info-value">{{ $user->phone ?? 'No phone provided' }}</p>
                                </div>
                            </div>
                            
                            <!-- Gender -->
                            <div style="display: flex; flex-direction: column; border-top: 1px solid #f3f4f6; padding-top: 1rem;">
                                <div>
                                    <label class="info-label">Gender</label>
                                </div>
                                <div style="margin-top: 0.25rem;">
                                    <p class="info-value">{{ $user->gender ?? 'No gender provided' }}</p>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
                            <a href="{{ route('profile.edit') }}" class="btn-success">
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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