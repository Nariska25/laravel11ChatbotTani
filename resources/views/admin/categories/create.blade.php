@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Kategori</h1>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="deskripsi_kategori">Deskripsi Kategori</label>
                <textarea name="deskripsi_kategori" id="deskripsi_kategori" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
