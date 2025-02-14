@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Hero Section</h2>
        <form action="{{ route('admin.hero.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="image">Gambar</label>
                <input type="file" class="form-control" name="image" required>
            </div>
            <div class="form-group">
                <label for="title">Judul</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea class="form-control" name="description" rows="4" required></textarea>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="is_active" checked>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
@endsection
