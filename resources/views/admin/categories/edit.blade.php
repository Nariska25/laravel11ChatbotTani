@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Edit Kategori</h1>

    <form action="{{ route('admin.categories.update', ['category' => $category->category_id]) }}" method="POST">
        @csrf
        @method('PUT')
    
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="category_name" class="form-control" value="{{ $category->category_name }}">
        </div>
    
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
    
</div>
@endsection
