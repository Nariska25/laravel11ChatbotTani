@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 text-center">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <img src="{{ asset('storage/' . $product->products_image) }}" 
                         alt="{{ $product->products_name }}" 
                         class="img-fluid rounded" 
                         style="max-height: 500px; object-fit: contain;">
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h1 class="fw-bold mb-3">{{ $product->products_name }}</h1>
                    
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-primary me-2">{{ $product->category->category_name }}</span>
                        <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                            {{ $product->stock > 0 ? 'Stok Tersedia' : 'Stok Habis' }}
                        </span>
                    </div>
                    
                    <h2 class="text-primary fw-bold mb-4">Rp {{ number_format($product->discounted_price, 0, ',', '.') }}</h2>
                    
                    <div class="mb-4">
                        <h5 class="fw-bold">Deskripsi Produk:</h5>
                        <p class="mb-0">{!! nl2br(e($product->products_description)) !!}</p>
                    </div>
                    
                    <hr>
                    
                    <!-- Quantity Selector -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Jumlah:</label>
                        <div class="input-group" style="width: 150px;">
                            <button type="button" class="btn btn-outline-secondary btn-minus">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" name="amount" value="1" min="1" max="{{ $product->stock }}" 
                            class="form-control text-center quantity-input" id="quantityInput">

                            <button type="button" class="btn btn-outline-secondary btn-plus">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <small class="text-muted">Stok tersedia: {{ $product->stock }}</small>
                    </div>     
                    <!-- Add to Cart Button -->
                    <form action="{{ route('cart.store') }}" method="POST" id="addToCartForm">
                        @csrf
                        <input type="hidden" name="products_id" value="{{ $product->products_id }}">
                        <input type="hidden" name="products_name" value="{{ $product->products_name }}">
                        <input type="hidden" name="price" value="{{ $product->price }}">
                        <input type="hidden" name="amount" id="addToCartQuantity" value="1">
                        <input type="hidden" name="discount" value="0">
                        <button type="submit" class="btn btn-outline-primary btn-lg py-3" {{ $product->stock == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-cart-plus me-2"></i> Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('.btn-plus').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantityInput');
        let currentValue = parseInt(quantityInput.value);
        if (currentValue < {{ $product->stock }}) {
            quantityInput.value = currentValue + 1;
            document.getElementById('addToCartQuantity').value = currentValue + 1;
        }
    });

    document.querySelector('.btn-minus').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantityInput');
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            document.getElementById('addToCartQuantity').value = currentValue - 1;
        }
    });
</script>     
@endsection

