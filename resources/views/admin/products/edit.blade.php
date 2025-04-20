@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Produk</h1>
        <form action="{{ route('admin.products.update', $product->products_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="products_name">Nama Produk</label>
                <input type="text" name="products_name" id="products_name" class="form-control" value="{{ old('products_name', $product->products_name) }}" required>
                @error('products_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
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
                <textarea name="products_description" id="products_description" class="form-control" required>{{ old('products_description', $product->products_description) }}</textarea>
                @error('products_description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

           <div class="form-group">
                <label for="price">Harga</label>
                <input type="text" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="stock">Stok</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                @error('stock')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>          

            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}" {{ old('category_id', $product->category_id) == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- admin/products/edit.blade.php or create.blade.php -->
            <div class="form-group">
                <label for="recommendation">Recommend this product</label>
                <input type="checkbox" name="recommendation" id="recommendation" value="1" 
                {{ old('recommendation', $product->recommendation) ? 'checked' : '' }}>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>

            <!-- Tombol Batal -->
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
