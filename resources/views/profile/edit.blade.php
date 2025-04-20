@extends('layouts.app')

@section('content')
<section style="background-color: #eee;">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="mb-3">Edit Profile</h4>
                        
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            </div>
                            <div class="mb-3">
                                <label for="image_path" class="form-label">Foto Profile</label>
                                <input type="file" class="form-control" id="image_path" name="image_path">
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                <a href="{{ route('profile.show') }}" class="btn btn-secondary ms-2">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
