@extends('layouts.app')

@section('title', 'Shop')

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
        <h1 class="text-center text-white display-6">Produk</h1>
    </div>
    <!-- Page Header End -->

    <!-- Filter Section Start -->
    <div class="container -4">
        <div class="row">
            <div class="col-xl-3 mb-4">
                <div class="bg-light p-3 rounded d-flex justify-content-between align-items-center">
                    <label for="categories" class="mb-0 fw-bold">Kategori:</label> <!-- Added fw-bold for bold text -->
                    <form action="{{ url('/shop') }}" method="GET" id="fruitform">
                        <select id="categories" name="kategori" class="form-select border-0 bg-light" onchange="this.form.submit()">
                            <option value="all" {{ request()->kategori == 'all' ? 'selected' : '' }}>All</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->kategori_id }}" {{ request()->kategori == $category->kategori_id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Filter Section End -->

    <!-- Product Display Start -->
    <div class="container">
        <div class="row g-4">
            @foreach ($products as $product)
                <div class="col-md-3">
                    <div class="card rounded position-relative product-item">
                        <div class="product-img position-relative">
                            <div class="text-white px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px; 
                                background-color: {{ $product->kategori->nama_kategori == 'Bibit' ? '#28a745' : ($product->kategori->nama_kategori == 'Pupuk' ? '#ffc107' : '#6c757d') }};">
                                {{ $product->kategori->nama_kategori ?? 'Produk' }}
                            </div>
                            <img src="{{ asset('storage/' . $product->gambar_produk) }}" class="img-fluid w-100 rounded-top" alt="{{ $product->nama_produk }}">
                        </div>
                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                            <h5 class="card-title">{{ $product->nama_produk }}</h5>
                            <p>Rp. {{ number_format($product->harga, 0, '.', '.') }}</p>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('detail', ['id' => $product->produk_id]) }}" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Product Display End -->

@endsection
