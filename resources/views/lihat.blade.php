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
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Product Detail</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Shop</a></li>
            <li class="breadcrumb-item active text-white">Product Detail</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        <div class="col-lg-6">
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
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold mb-3">{{ $product->nama_produk }}</h4>
                            <p><strong>Category:</strong> {{ $product->kategori->nama_kategori }}</p>
                            <h5 class="fw-bold mb-3">${{ $product->harga }}</h5>
                            <p class="mb-4">{{ $product->deskripsi_produk }}</p>
                            <div class="input-group quantity mb-5" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border" >
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm text-center border-0" value="1">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <a href="#" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <h4 class="fw-bold mb-3">Related Products</h4>
                    <div class="row g-4">
                        @foreach($relatedProducts as $related)
                            <div class="col-lg-12">
                                            @if($product->gambar_produk)
                                            <img src="{{ asset('storage/' . $product->gambar_produk) }}" 
                                                alt="{{ $product->nama_produk }}" 
                                                class="img-fluid rounded mb-3" 
                                                style="max-height: 400px; object-fit: cover;">
                                        @else
                                            <p>No image available</p>
                                        @endif
                                        <h5>{{ $related->nama_produk }}</h5>
                                        <p>${{ $related->harga }}</p>
                                        <a href="{{ route('detail', $related->produk_id) }}" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->
@endsection