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

    @if($orders->isEmpty())
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-box-open fa-4x text-light"></i>
                </div>
                <h3 class="h4 mb-3">No Orders Found</h3>
                <p class="text-muted mb-4">You haven't placed any orders yet.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-success  px-4 rounded-pill">
                    <i class="fas fa-store me-2"></i> Browse Products
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($orders as $order)
                @php
                    $bgClass = match($order->order_status) {
                        'dibatalkan' => 'bg-success bg-opacity-10',
                        'selesai' => 'bg-primary bg-opacity-10',
                        'dikirim' => 'bg-danger bg-opacity-10',
                        'sedang dikemas' => 'bg-warning bg-opacity-10',
                        'telah dibayar' => 'bg-info bg-opacity-10',
                        'belum bayar' => 'bg-secondary bg-opacity-10',
                        default => 'bg-light',
                    };
                @endphp

                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                        <div class="card-header bg-white border-bottom px-4 py-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0 fw-medium">Order #{{ $order->order_id }}</h5>
                                <span class="badge {{ $bgClass }} text-dark text-capitalize rounded-pill px-3 py-1">
                                    {{ str_replace('_', ' ', $order->order_status) }}
                                </span>
                            </div>
                            <small class="text-muted">
                                {{ $order->created_at->format('d M Y h:i A') }}
                            </small>
                        </div>

                        <div class="card-body px-4 py-3">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Est. Delivery:</span>
                                <span class="fw-medium">
                                    @if(\Carbon\Carbon::hasFormat($order->delivery_estimate, 'Y-m-d'))
                                        {{ \Carbon\Carbon::parse($order->delivery_estimate)->format('d M Y') }}
                                    @else
                                        {{ $order->delivery_estimate }}
                                    @endif
                                </span>
                            </div>

                            <div class="border-top border-bottom py-3 my-3">
                                <div class="d-flex align-items-center mb-2 small text-muted">
                                    <i class="fas fa-shipping-fast me-1"></i> {{ $order->courier }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-credit-card me-1"></i> {{ $order->payment_method }}
                                </div>
                                @if($order->items->isNotEmpty())
                                    <h6 class="mb-1 fw-medium text-truncate">{{ $order->items[0]->products_name }}</h6>
                                    <p class="text-muted small mb-0">
                                        @if($order->items->count() > 1)
                                            +{{ $order->items->count() - 1 }} other items • {{ $order->items->sum('amount') }} total
                                        @else
                                            {{ $order->items->sum('amount') }} item
                                        @endif
                                    </p>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
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

        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                {{ $orders->onEachSide(1)->links() }}
            </nav>
        </div>
    @endif
</div>

<style>
    .pagination {
        justify-content: center;
        margin-top: 1rem;
    }

    .pagination .page-link {
        border-radius: 50px;
        padding: 0.375rem 0.75rem;
        font-size: 0.9rem;
        margin: 0 2px;
        color: #198754; /* Bootstrap green */
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
