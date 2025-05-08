@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<div class="container py-5">
    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center">
                    <form action="{{ url('/shop') }}" method="GET" class="w-75">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control p-3" placeholder="Enter keywords" value="{{ request()->search }}" aria-describedby="search-icon-1">
                            <button class="btn btn-success" type="submit" id="search-icon-1"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->

    <!-- Filter Section -->
    <section class="container mb-5">
        <div class="row g-3 align-items-center">
            <div class="col-xl-3">
                <div class="filter-card">
                    <form action="{{ url('/shop') }}" method="GET" id="categoryForm">
                        <div class="d-flex align-items-center justify-content-between">
                            <label class="filter-label">Category:</label>
                            <select id="categories" name="kategori" class="form-select filter-select" onchange="this.form.submit()">
                                <option value="all" {{ request()->kategori == 'all' ? 'selected' : '' }}>All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}" {{ request()->kategori == $category->category_id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-9">
                <form action="{{ url('/shop') }}" method="GET" class="search-form">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control search-input" 
                               placeholder="Search products..." value="{{ request()->search }}">
                        <button type="submit" class="btn btn-success search-btn">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Product Grid -->
    <section class="container mb-5">
        <div class="row g-4">
            @foreach ($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ asset('storage/' . $product->products_image) }}" 
                                 class="product-img" 
                                 alt="{{ $product->products_name }}">
                            @if ($product->sale)
                                <div class="product-badge">Sale</div>
                            @endif
                        </div>
                        <div class="product-details">
                            <h3 class="product-title">{{ Str::limit($product->products_name, 40) }}</h3>
                            <div class="price-wrapper">
                                @if ($product->sale)
                                    <span class="originalprice">Rp. {{ number_format($product->price, 0, '.', '.') }}</span>
                                    <span class="discountedprice">Rp. {{ number_format($product->discounted_price, 0, '.', '.') }}</span>
                                @else
                                    <span class="discountedprice">Rp. {{ number_format($product->price, 0, '.', '.') }}</span>
                                @endif
                            </div>
                            <div class="product-actions">
                                <a href="{{ route('detail', ['id' => $product->products_id]) }}" 
                                   class="btn btn-success detail-btn">
                                    <i class="fas fa-eye me-2"></i>View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </section>
@endsection