@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Kelola Produk</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Produk</h6>
            <!-- Posisi tombol tambah produk di dalam card-header -->
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary border">Tambah Produk</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Deskripsi Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th>Gambar</th>
                            <th>Rekomendasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td> <!-- Nomor urut otomatis -->
                                <td>{{ $product->products_name}}</td>
                                <!-- Membatasi deskripsi produk -->
                                <td style="max-width: 200px; max-height: 80px; overflow: hidden;">
                                    <div style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $product->products_description }}
                                    </div>
                                </td>                                
                                <!-- Format harga dengan Rp dan pemisah ribuan -->
                                <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ optional($product->category)->category_name ?? 'Tidak ada kategori' }}</td>
                                <td>
                                    @if ($product->products_image)
                                        <img src="{{ asset('storage/' . $product->products_image) }}" alt="Gambar Produk" width="50">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td> <td>
                                    <input type="checkbox" class="toggle-rekomendasi" data-id="{{ $product->products_id }}" 
                                    {{ $product->recommendation == 1 ? 'checked' : '' }}>                                    
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.products.edit', $product->products_id) }}" class="btn btn-warning btn-sm mb-2">Edit</a>
                                        <form action="{{ route('admin.products.destroy', $product->products_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>                                                                           
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $(".toggle-rekomendasi").change(function () {
        var productId = $(this).data("id");
        var isChecked = $(this).is(":checked") ? 1 : 0;

        $.ajax({
            url: "/admin/products/update-rekomendasi/" + productId,
            type: "POST",
            data: {
                rekomendasi: isChecked,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                alert(response.message);
            },
            error: function () {
                alert("Gagal memperbarui rekomendasi!");
            }
        });
    });
});
</script>

@endsection
