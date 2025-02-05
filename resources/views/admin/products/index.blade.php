@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Data Produk</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data Produk</h6>
            <!-- Posisi tombol tambah produk di dalam card-header -->
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary border">Tambah Produk</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Deskripsi Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->nama_produk }}</td>
                                <!-- Membatasi deskripsi produk -->
                                <td class="text-truncate" style="max-width: 200px;">
                                    {{ $product->deskripsi_produk }}
                                </td>
                                <!-- Format harga dengan Rp dan pemisah ribuan -->
                                <td>Rp. {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td>{{ $product->stok }}</td>
                                <td>{{ optional($product->category)->nama_kategori ?? 'Tidak ada kategori' }}</td>
                                <td>
                                    @if ($product->gambar_produk)
                                        <img src="{{ asset('storage/' . $product->gambar_produk) }}" alt="Gambar Produk" width="50">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->produk_id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product->produk_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
