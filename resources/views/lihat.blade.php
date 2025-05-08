@extends('layouts.app')

@section('title', 'Detail Product')

@section('content')
<div class="container py-5" style="margin-top: 100px;">

    <!-- Single Page Header -->
    <div class="container-fluid page-header py-5">
        <div class="text-center">
            <h1 class="display-5 text-white fw-bold mb-3">{{ $product->nama_produk }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-white">Home</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-white">Shop</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Product Detail</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Product Detail Section -->
    <div class="container py-5">
        <div class="row g-5">
            <!-- Main Product Content -->
            <div class="col-lg-8">
                <div class="row g-5">
                    <!-- Product Image -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-lg rounded-3 overflow-hidden">
                            @if($product->gambar_produk)
                                <img src="{{ asset('storage/' . $product->gambar_produk) }}" 
                                     alt="{{ $product->nama_produk }}" 
                                     class="img-fluid p-4" 
                                     style="object-fit: contain; height: 400px;">
                            @else
                                <div class="bg-light p-5 text-center">
                                    <p class="text-muted mb-0">No image available</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="col-lg-6">
                        <div class="product-details">
                            <div class="mb-4">
                                <span class="badge bg-primary mb-2">{{ $product->kategori->nama_kategori }}</span>
                                <h2 class="fw-bold mb-3">{{ $product->nama_produk }}</h2>
                                <h3 class="text-primary fw-bold mb-4">${{ number_format($product->harga, 2) }}</h3>
                                <p class="text-muted lead mb-4">{{ $product->deskripsi_produk }}</p>
                            </div>

                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $product->produk_id }}">
                                <input type="hidden" name="nama_produk" value="{{ $product->nama_produk }}">
                                <input type="hidden" name="harga" value="{{ $product->harga }}">
                                <input type="hidden" name="jumlah" id="quantityValue" value="1">
                                
                                <div class="d-flex align-items-center mb-4">
                                    <div class="input-group quantity me-3" style="width: 130px;">
                                        <button class="btn btn-outline-secondary border px-3" type="button" id="decrementBtn">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <input type="text" class="form-control text-center border" value="1" id="quantityInput" readonly>
                                        <button class="btn btn-outline-secondary border px-3" type="button" id="incrementBtn">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                        <i class="fa fa-shopping-cart me-2"></i>Add to Cart
                                    </button>
                                </div>
                            </form>

                            <div class="border-top pt-4">
                                <h5 class="fw-bold mb-3">Product Details</h5>
                                <dl class="row">
                                    <dt class="col-sm-4">SKU</dt>
                                    <dd class="col-sm-8">#{{ $product->produk_id }}</dd>

                                    <dt class="col-sm-4">Category</dt>
                                    <dd class="col-sm-8">{{ $product->kategori->nama_kategori }}</dd>

                                    <dt class="col-sm-4">Stock Status</dt>
                                    <dd class="col-sm-8">In Stock ({{ $product->stok }})</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <h4 class="fw-bold mb-4">Related Products</h4>
                        <div class="row g-4">
                            @foreach($relatedProducts as $related)
                            <div class="col-12">
                                <div class="card card-hover border-0 shadow-sm">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-4">
                                            <img src="{{ asset('storage/' . $related->gambar_produk) }}" 
                                                 alt="{{ $related->nama_produk }}"
                                                 class="img-fluid rounded-start"
                                                 style="height: 100px; object-fit: cover;">
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body">
                                                <h6 class="card-title mb-1">{{ Str::limit($related->nama_produk, 25) }}</h6>
                                                <p class="text-primary fw-bold mb-2">${{ number_format($related->harga, 2) }}</p>
                                                <a href="{{ route('detail', $related->produk_id) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    View Product
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('quantityInput');
        const quantityValue = document.getElementById('quantityValue');
        const incrementBtn = document.getElementById('incrementBtn');
        const decrementBtn = document.getElementById('decrementBtn');
        const maxStock = {{ $product->stok }};
        
        // Initialize values
        let quantity = 1;
        
        // Update quantity display and hidden input
        function updateQuantity() {
            quantityInput.value = quantity;
            quantityValue.value = quantity;
        }
        
        // Increment quantity
        incrementBtn.addEventListener('click', function() {
            if (quantity < maxStock) {
                quantity++;
                updateQuantity();
            } else {
                alert('Cannot exceed available stock');
            }
        });
        
        // Decrement quantity
        decrementBtn.addEventListener('click', function() {
            if (quantity > 1) {
                quantity--;
                updateQuantity();
            }
        });
    });
</script>
@endpush
