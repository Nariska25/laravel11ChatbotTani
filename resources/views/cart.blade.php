@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')

<div class="container py-5" style="margin-top: 100px;">
    <div class="row">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Keranjang Belanja</h2>
                <span class="badge bg-success rounded-pill">{{ $cartItems->sum('amount') }} item</span>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($cartItems->isEmpty())
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3 w-100">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-box-open fa-4x text-light"></i>
                            </div>
                            <h3 class="h4 mb-3">Oops, your cart is empty!</h3>
                            <p class="text-muted mb-4">Start shopping and discover interesting products!</p>
                            <a href="{{ route('shop.index') }}" class="btn btn-success px-4 rounded-pill">
                                <i class="fas fa-store me-2"></i> Browse Products
                            </a>
                        </div>
                    </div>
                </div>
            @else        
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach ($cartItems as $cart)
                                <div class="list-group-item p-4">
                                    <div class="row align-items-center">
                                        <div class="col-auto d-flex align-items-center">
                                            <input type="checkbox" class="product-checkbox me-3" 
                                                data-id="{{ $cart->carts_id }}" 
                                                data-price="{{ $cart->product->price }}" 
                                                data-amount="{{ $cart->amount }}">
                                            <img src="{{ asset('storage/' . $cart->product->products_image) }}" 
                                                 alt="{{ $cart->product->products_name }}" 
                                                 class="rounded-3" 
                                                 style="width: 90px; height: 90px; object-fit: cover;">
                                        </div>
                                        <div class="col">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h5 class="fw-bold mb-1">{{ $cart->product->products_name }}</h5>
                                                    <p class="text-muted mb-1">Stok: {{ $cart->product->stock }}</p>
                                                </div>
                                                <form action="{{ route('cart.remove', $cart->carts_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="fw-bold mb-0 text-success">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-outline-secondary btn-sm btn-minus" 
                                                            data-id="{{ $cart->carts_id }}" type="button">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="text" 
                                                           class="form-control form-control-sm text-center mx-2 amount-input" 
                                                           value="{{ $cart->amount }}" 
                                                           style="width: 60px;"
                                                           data-id="{{ $cart->carts_id }}"
                                                           data-price="{{ $cart->product->price }}"
                                                           data-max="{{ $cart->product->stock }}">
                                                    <button class="btn btn-outline-secondary btn-sm btn-plus" 
                                                            data-id="{{ $cart->carts_id }}" type="button">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div>
                                                    <p class="fw-bold mb-0 total-price-per-product" 
                                                       id="totalPrice{{ $cart->carts_id }}">
                                                        Rp {{ number_format($cart->product->price * $cart->amount, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if (!$cartItems->isEmpty())
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">Ringkasan Belanja</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold text-success" id="total">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <form id="checkoutForm" action="{{ route('checkout.index') }}" method="GET">
                        <input type="hidden" name="selected_products" id="selectedProductsInput" value="">
                        <button type="submit" class="btn btn-success w-100 py-3 fw-bold">
                            <i class="fas fa-credit-card me-2"></i> Lanjut ke Pembayaran
                        </button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('shop.index') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i> Lanjutkan Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    function updateSummary() {
        let total = 0;
        $('.product-checkbox:checked').each(function() {
            const price = parseFloat($(this).data('price'));
            const amount = parseInt($(this).data('amount'));
            total += price * amount;
        });
        if (total > 0) {
            $('#subtotal').text('Rp ' + total.toLocaleString('id-ID'));
            $('#total').text('Rp ' + total.toLocaleString('id-ID'));
        } else {
            $('#subtotal').text('Rp 0');
            $('#total').text('Rp 0');
        }
    }

    // Event untuk tombol plus dan minus
    $(document).on('click', '.btn-minus, .btn-plus', function(e) {
        e.preventDefault();
        const input = $(this).siblings('.amount-input');
        let currentVal = parseInt(input.val()) || 1;
        const maxStock = parseInt(input.data('max'));
        const productId = input.data('id');
        const price = parseFloat(input.data('price'));

        if ($(this).hasClass('btn-plus')) {
            if (currentVal < maxStock) {
                input.val(currentVal + 1);
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok tidak mencukupi',
                    text: 'Jumlah melebihi stok yang tersedia',
                });
                return;
            }
        } else {
            if (currentVal > 1) {
                input.val(currentVal - 1);
            } else {
                return;
            }
        }

        input.trigger('change');
    });
    $('#checkoutForm').on('submit', function(e) {
    // Ambil semua checkbox yang dicentang
    let selectedIds = [];
    $('.product-checkbox:checked').each(function() {
        selectedIds.push($(this).data('id'));
    });
    // Jika tidak ada produk yang dipilih, batalkan submit dan beri alert
    if (selectedIds.length === 0) {
        e.preventDefault();
        alert('Pilih minimal 1 produk untuk melanjutkan pembayaran.');
        return false;
    }
    // Set value input hidden dengan string list id, misal "1,2,3"
    $('#selectedProductsInput').val(selectedIds.join(','));
    });

    // Event saat jumlah diubah
    $(document).on('change', '.amount-input', function() {
        const input = $(this);
        const productId = input.data('id');
        let newQuantity = parseInt(input.val()) || 1;
        const maxStock = parseInt(input.data('max'));
        const price = parseFloat(input.data('price'));

        if (newQuantity > maxStock) {
            Swal.fire({
                icon: 'warning',
                title: 'Stok tidak mencukupi',
                text: 'Jumlah melebihi stok yang tersedia',
            });
            newQuantity = maxStock;
            input.val(maxStock);
        } else if (newQuantity < 1) {
            newQuantity = 1;
            input.val(1);
        }

        const newTotal = price * newQuantity;
        $('#totalPrice' + productId).text('Rp ' + newTotal.toLocaleString('id-ID'));

        // Update data-amount di checkbox terkait supaya update summary tepat
        const checkbox = input.closest('.list-group-item').find('.product-checkbox');
        if (checkbox.length) {
            checkbox.data('amount', newQuantity);
        }

        $.ajax({
            url: "{{ url('cart/update') }}/" + productId,
            method: 'PATCH',
            data: {
                amount: newQuantity,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                $('#totalPrice' + productId).text('Rp ' + response.total);
                if (response.cart_count) {
                    $('.cart-count').text(response.cart_count);
                    $('.badge.rounded-pill').text(response.cart_count + ' item');
                }
                if (response.subtotal) {
                    // Jangan langsung update subtotal dan total dari server
                    // karena kita ingin update berdasarkan checkbox yg dicentang
                    // Jadi panggil updateSummary() saja
                }

                Toast.fire({
                    icon: 'success',
                    title: response.message || 'Jumlah berhasil diupdate'
                });

                // Update ringkasan belanja
                updateSummary();
            },
            error: function(xhr) {
                if (xhr.status === 400) {
                    const response = xhr.responseJSON;
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message || 'Terjadi kesalahan',
                    });
                    input.val(response.max_stock || 1);
                    $('#totalPrice' + productId).text('Rp ' + (price * (response.max_stock || 1)).toLocaleString('id-ID'));
                }
            }
        });
    });

    // Event saat checkbox dicentang atau tidak
    $(document).on('change', '.product-checkbox', function() {
        updateSummary();
    });

    // Inisialisasi ringkasan saat halaman load
    updateSummary();

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
});
</script>
@endpush
