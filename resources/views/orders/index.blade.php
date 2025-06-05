@extends('layouts.app')

@section('content')
<div class="container py-5" style="margin-top: 100px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">My Orders</h1>
            <p class="text-muted mb-0">View and manage your order history</p>
        </div>
        <a href="{{ route('shop.index') }}" class="btn btn-outline-success rounded-pill">
            <i class="fas fa-arrow-left me-2"></i> Continue Shopping
        </a>
    </div>

    @if($orders->count() === 0)
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-box-open fa-4x text-light"></i>
                </div>
                <h3 class="h4 mb-3">No Orders Found</h3>
                <p class="text-muted mb-4">You haven't placed any orders yet.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-success px-4 rounded-pill">
                    <i class="fas fa-store me-2"></i> Browse Products
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($orders as $order)
            @php
                $status = strtolower($order->order_status);
                $isExpired = $status === 'belum bayar' && $order->expires_at && now()->greaterThan(\Carbon\Carbon::parse($order->expires_at));

                if ($isExpired) {
                    $status = 'expired';
                }

                $bgClass = match($status) {
                    'dibatalkan' => 'bg-danger bg-opacity-10 text-white',
                    'selesai' => 'bg-success bg-opacity-10 text-white',
                    'dikirim' => 'bg-primary bg-opacity-10 text-white',
                    'sedang dikemas' => 'bg-primary bg-opacity-10 text-white',
                    'telah dibayar' => 'bg-info bg-opacity-10 text-white',
                    'belum bayar' => 'bg-secondary bg-opacity-10 text-white',
                    'expired' => 'bg-dark bg-opacity-10 text-white',
                    default => 'bg-light text-dark',
                };
            @endphp
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                    <div class="card-header bg-white border-bottom px-4 py-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0 fw-medium">Order #{{ $order->order_id }}</h5>
                            <span class="badge {{ $bgClass }} text-dark text-capitalize rounded-pill px-3 py-1">
                                {{ $isExpired ? 'Expired' : ucfirst($order->order_status) }}
                            </span>
                        </div>
                        <small class="text-muted">
                            {{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y h:i A') }}
                        </small>
                    </div>
                
                    <div class="card-body">

                        <!-- Tampilkan expired jika status 'Belum Bayar' dan waktu telah habis -->
                        @if(strtolower($order->order_status) === 'belum bayar' && $order->expires_at && now()->lessThan(\Carbon\Carbon::parse($order->expires_at)))
                            <div class="mb-3 text-danger fw-semibold">
                                Harap bayar sebelum: {{ \Carbon\Carbon::parse($order->expires_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                            </div>
                        @endif
                        <!-- Shipping Info Section -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-1">
                                @if($order->shippingMethod)
                                    <i class="fas fa-truck-moving text-danger me-2"></i>
                                    <span class="fw-medium">{{ $order->shippingMethod->courier }}</span>
                                @else
                                    <span class="text-muted">Belum memilih kurir</span>
                                @endif
                            </div>
                            
                            <div class="d-flex align-items-center text-muted small">
                                <span class="me-1">Est. Delivery:</span>
                                <span>
                                    @if($order->shippingMethod)
                                        {{ $order->shippingMethod->delivery_estimate }}
                                    @else
                                        1-3 hari
                                    @endif
                                </span>
                            </div>
                        </div>
                    
                        <!-- Product Info -->
                        @if($order->items->isNotEmpty())
                            <div class="border-top pt-2 mb-3">
                                <h6 class="mb-1 fw-medium">{{ $order->items[0]->product->products_name }}</h6>
                                <p class="text-muted small mb-0">
                                    {{ $order->items->sum('amount') }} item
                                    @if($order->items->count() > 1)
                                        • {{ $order->items->count() }} produk
                                    @endif
                                </p>
                            </div>
                        @endif
                    
                        <!-- Total and Details -->
                        <div class="d-flex justify-content-between align-items-center border-top pt-3">
                            <div>
                                <span class="text-muted small">Total</span>
                                <h5 class="mb-0 fw-bold">Rp {{ number_format($order->total_payment, 0, ',', '.') }}</h5>
                            </div>
                            <a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-sm btn-success rounded-pill px-3">
                                Details <i class="fas fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            <div class="d-flex justify-content-center">
                {{ $orders->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>

<style>
    .pagination {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 0.5rem;
    }

    .pagination .page-item {
        flex-shrink: 0;
    }

    .pagination .page-link {
        border-radius: 50px;
        padding: 0.375rem 0.75rem;
        font-size: 0.9rem;
        margin: 0 2px;
        color: #198754;
        border: 1px solid #dee2e6;
    }

    .pagination .page-item.active .page-link {
        background-color: #198754;
        border-color: #198754;
        color: #fff;
    }

    .pagination .page-item.disabled .page-link {
        color: #ccc;
    }
</style>
@endsection
