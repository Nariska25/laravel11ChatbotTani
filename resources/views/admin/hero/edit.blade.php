@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Hero Section</h2>
        <form action="{{ route('admin.hero.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="image">Gambar</label>
                <input type="file" name="image" id="image" class="form-control" value="{{ old('image', $section->image) }}" required>
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="title">Judul</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $section->title) }}" required>
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <input type="text" name="description" id="description" class="form-control" value="{{ old('description', $section->description) }}" required>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="is_active" checked>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>

            <!-- Tombol Batal -->
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection

