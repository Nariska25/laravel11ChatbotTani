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

    <style>
        /* Promotional Cards */
        .promo-card {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            height: 350px;
            transition: transform 0.3s ease;
        }

        .promo-card:hover {
            transform: translateY(-5px);
        }

        .promo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .promo-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2rem;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            color: white;
        }

        .promo-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .promo-text {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        /* Product Cards */
        .product-card {
            border: 1px solid #e9ecef;
            border-radius: 0.7rem;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: white;
        }

        .product-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .product-image {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-img {
            transform: scale(1.05);
        }

        .product-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #dc3545;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .product-details {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #2d3748;
        }

        .price-wrapper {
            margin-bottom: 1rem;
        }

        .discountedprice {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2563eb;
        }

        .originalprice {
            font-size: 0.875rem;
            color: #718096;
            text-decoration: line-through;
            margin-right: 0.5rem;
        }

        .detail-btn, .add-to-cart-btn {
            width: 100%;
            padding: 0.75rem;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 0.5rem;
        }

        .add-to-cart-btn {
            background: #28a745;
            border: none;
        }

        .add-to-cart-btn:hover {
            background: #218838;
        }

        /* Filter Section */
        .filter-card {
            background: white;
            padding: 1rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }

        .filter-label {
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 0;
            white-space: nowrap;
        }

        .filter-select {
            border: none;
            background: transparent;
            font-weight: 500;
            width: auto;
            max-width: 200px;
        }

        .search-input {
            border-radius: 0.75rem;
            padding: 0.75rem 1.25rem;
            border: 1px solid #e2e8f0;
        }

        .search-btn {
            border-radius: 0 0.75rem 0.75rem 0;
            padding: 0.75rem 1.5rem;
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
        }

        .pagination .page-item .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        .pagination .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .pagination .page-link:hover {
            z-index: 2;
            color: #0056b3;
            text-decoration: none;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
    </style>
</div>
@endsection