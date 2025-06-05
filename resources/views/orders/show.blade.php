@extends('layouts.app')

@section('content')
<div class="container py-4" style="margin-top: 80px;">
    <div class="row">
        {{-- LEFT COLUMN --}}
        <div class="col-lg-8 mb-4">
            {{-- ORDER HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h4 mb-1">Order #{{ $order->order_id }}</h2>
                    <p class="text-muted mb-0">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                </div>
                <span class="badge rounded-pill px-3 py-2 
                    @switch($order->order_status)
                        @case('Belum Bayar') bg-warning text-dark @break
                        @case('Telah Dibayar') bg-info text-dark @break
                        @case('Sedang Dikemas') bg-primary @break
                        @case('Dikirim') bg-primary @break
                        @case('Selesai') bg-success @break
                        @case('Dibatalkan') bg-danger @break
                        @default bg-secondary
                    @endswitch">
                    {{ $order->order_status }}
                </span>
            </div>

            {{-- ORDER ITEMS --}}
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h3 class="h6 mb-0">Order Items ({{ $order->items->count() }})</h3>
                </div>
                <div class="card-body p-0">
                    @foreach($order->items as $item)
                        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/' . $item->product->products_image) }}" 
                                     alt="{{ $item->product->products_name }}" class="rounded-2 me-3" width="72" height="72">
                                <div>
                                    <div class="fw-medium">{{ $item->product->products_name }}</div>
                                    <small class="text-muted">SKU: {{ $item->product->product_sku ?? 'N/A' }}</small>
                                    <div class="mt-1">
                                        <span class="badge bg-light text-dark">Qty: {{ $item->amount }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-medium">Rp {{ number_format($item->product->discounted_price, 0, ',', '.') }}</div>
                                <small class="text-muted">Rp {{ number_format($item->subtotal, 0, ',', '.') }} total</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- SHIPPING DETAILS --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h3 class="h6 mb-0">Shipping Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Courier --}}
                        <div class="col-md-6 mb-3">
                            <div class="bg-light p-3 rounded-2">
                                <h4 class="h6 text-muted mb-2">Courier Details</h4>
                                @if($order->shippingMethod)
                                    <p class="mb-1"><strong>Service:</strong> 
                                        {{ $order->shippingMethod->courier }} - {{ $order->shippingMethod->courier_service }}
                                    </p>
                                    <p class="mb-1"><strong>Cost:</strong> Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
                                @endif
                                @if(in_array($order->order_status, ['Dikirim', 'Selesai']))
                                    <p class="mb-0"><strong>Tracking #:</strong> {{ $order->tracking_number ?? 'Not available' }}</p>
                                @endif
                            </div>
                        </div>
                        {{-- Address --}}
                        <div class="col-md-6">
                            <div class="border p-3 rounded-3 h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <h4 class="h6 mb-0">Shipping Address</h4>
                                </div>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-1"><i class="fas fa-user text-muted me-2 small"></i> <strong>{{ $user->name }}</strong></li>
                                    <li class="mb-1"><i class="fas fa-phone text-muted me-2 small"></i> {{ $user->phone }}</li>
                                    <li class="mb-1"><i class="fas fa-map-marker text-muted me-2 small"></i> {{ $user->address }}</li>
                                    <li class="mb-1"><i class="fas fa-city text-muted me-2 small"></i> {{ $user->city }}, {{ $user->province }} {{ $user->postal_code }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-4">
            {{-- PAYMENT SUMMARY --}}
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h3 class="h6 mb-0">Payment Summary</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal:</span>
                        <span>Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
                    </div>

                    @if($order->discount > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Discount:</span>
                            <span class="text-danger">- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping:</span>
                        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>

                    <div class="border-top pt-3 mt-2 d-flex justify-content-between">
                        <span class="fw-bold">Total Payment:</span>
                        <span class="fw-bold">Rp {{ number_format($order->total_payment, 0, ',', '.') }}</span>
                    </div>

                    {{-- Tombol Bayar --}}
                    @if($order->order_status === 'Belum Bayar')
                    <form action="{{ route('orders.pay', $order->order_id) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100 py-2 rounded-pill">
                            <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                        </button>
                    </form>
                    @endif


                    {{-- Tombol Batal --}}
                    @if($order->order_status === 'Belum Bayar')
                        <form action="{{ route('orders.cancel', $order->order_id) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 py-2 rounded-pill">
                                <i class="fas fa-times me-2"></i>Cancel Order
                            </button>
                        </form>
                    @endif

                    {{-- Xendit Invoice --}}
                    @if($order->xendit_invoice_id)
                        <div class="mt-3 small text-muted">
                            <div class="d-flex justify-content-between">
                                <span>Invoice ID:</span>
                                <span>{{ $order->xendit_invoice_id }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- TRACK ORDER --}}
            @if(in_array($order->order_status, ['Dikirim']))
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-bottom py-3">
                        <h3 class="h6 mb-0">Track Your Order</h3>
                    </div>
                    <div class="card-body">
                        <a href="https://cekresi.com/?noresi={{ $order->tracking_number }}" class="btn btn-outline-secondary w-100 py-2 rounded-pill" target="_blank">
                            <i class="fas fa-truck me-2"></i>Track Shipment
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
