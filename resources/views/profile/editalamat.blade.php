@extends('layouts.app')

@section('content')
<section style="background-color: #eee;">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="mb-3">Edit Alamat</h4>

                        <form action="{{ route('profile.updateAlamat', ['redirect' => request()->query('redirect')]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            @if(request()->has('redirect'))
                            <input type="hidden" name="redirect" value="{{ request()->query('redirect') }}">
                            @endif
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="city" class="form-label">Kota</label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $user->city) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="postal_code" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="province" class="form-label">Provinsi</label>
                                <input type="text" class="form-control" id="province" name="province" value="{{ old('province', $user->province) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                            </div>
                            <form action="{{ route('profile.updateAlamat') }}" method="POST">
                                @csrf
                                @method('PUT')
                            
                                <!-- input alamat, kota, dsb -->
                            
                                <input type="hidden" name="redirect" value="{{ request()->query('redirect', route('profile.alamat')) }}">
                            
                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                            </form>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
