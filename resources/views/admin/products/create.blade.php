@extends('admin.layouts.app')

@section('content')
    <h1>Tambah Produk</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="products_name">Nama Produk</label>
            <input type="text" name="products_name" id="products_name" class="form-control" value="{{ old('products_name') }}" placeholder="Masukkan Nama" required>
        </div>
        <div class="form-group">
            <label for="products_image">Gambar Produk</label>
            <input type="file" name="products_image" id="products_image" class="form-control">
            @error('products_image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>       

        <div class="form-group">
            <label for="products_description">Deskripsi Produk</label>
            <textarea name="products_description" id="products_description" class="form-control" placeholder="Masukkan Deskripsi" required>{{ old('products_description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" placeholder="Masukkan Harga" required>
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock">Stok</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}" placeholder="Masukkan Stok" required>
            @error('stok')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Kategori</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                        {{ $category->category_name}}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Recommendation Checkbox -->
        <div class="form-group">
            <label for="recommendation">Rekomendasikan Produk Ini</label>
            <input type="checkbox" name="recommendation" id="recommendation" value="1" {{ old('recommendation') ? 'checked' : '' }}>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection