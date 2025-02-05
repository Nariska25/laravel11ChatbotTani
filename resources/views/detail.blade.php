@extends('layouts.app')

@section('title', 'Detail Product')

@section('content')
    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div class="input-group w-75">
                        <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Detail Produk</h1>
    </div>
    <!-- Page Header End -->

                    <!-- Kolom Detail Produk -->
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <!-- Gambar Produk -->
                                    <div class="col-lg-6 text-center mb-3 mb-lg-0">
                                        @if($product->gambar_produk)
                                            <img src="{{ asset('storage/' . $product->gambar_produk) }}" 
                                                 alt="{{ $product->nama_produk }}" 
                                                 class="img-fluid rounded mb-3" 
                                                 style="max-height: 400px; object-fit: cover;">
                                        @else
                                            <p>No image available</p>
                                        @endif
                                    </div>

                                    <!-- Informasi Produk -->
                                    <div class="col-lg-6">
                                        <h4 class="fw-bold mb-3">{{ $product->nama_produk }}</h4>
                                        <p><strong>Category:</strong> {{ $product->kategori->nama_kategori }}</p>
                                        <h5 class="fw-bold text-success mb-3">Rp {{ number_format($product->harga, 0, '.', '.') }}</h5>
                                        <p><strong>Stok:</strong> {{ $product->stok }}</p>
                                        <p class="mb-4">{{ $product->deskripsi_produk }}</p>

                                      <!-- Form Tambah ke Keranjang -->
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $product->produk_id }}">
                            
                                <!-- Input jumlah produk -->
                                <div class="input-group quantity mb-4" style="width: 150px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border" onclick="decreaseQuantity()">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="number" name="jumlah" value="1" min="1" class="form-control" id="quantityInput">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border" onclick="increaseQuantity()">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Tombol Add to Cart -->
                                <button type="submit" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary">
                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                </button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            
@endsection
