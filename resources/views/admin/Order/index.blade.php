@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Kelola Order</h1>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="orderTabs" role="tablist">
        @php
            use Illuminate\Support\Str;

            $statuses = [
                'Belum Bayar' => $belumbayarOrders,
                'Telah Dibayar' => $telahdibayarOrders,
                'Sedang Dikemas' => $sedangdikemasOrders,
                'Dikirim' => $dikirimOrders,
                'Selesai' => $selesaiOrders,
                'Dibatalkan' => $dibatalkanOrders
            ];
        @endphp
        @foreach($statuses as $key => $orders)
            <li class="nav-item">
                <button class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#{{ Str::slug($key) }}" type="button" role="tab">
                    {{ $key }} ({{ $orders->count() }})
                </button>
            </li>
        @endforeach
    </ul>

    <!-- Tab Contents -->
    <div class="tab-content mt-4">
        @foreach($statuses as $statusKey => $orders)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ Str::slug($statusKey) }}" role="tabpanel">
                <div class="row">
                    @foreach($orders as $order)
                        <div class="col-md-4 mb-4">
                            <div class="order-card border p-3 h-100">
                                <h5>Order #{{ $order->order_id }}</h5>
                                <p>Status: {{ ucfirst($order->order_status) }}</p>

                                <!-- Produk -->
                                <p><strong>Products:</strong></p>
                                <ul>
                                    @foreach($order->items as $item)
                                        <li>{{ $item->products_name }} (x{{ $item->amount }})</li>
                                    @endforeach
                                </ul>

                                <p><strong>Total Payment:</strong> Rp{{ number_format($order->total_payment, 0, ',', '.') }}</p>

                                {{-- Aksi berdasarkan status --}}
                                @if($statusKey === 'Belum Bayar')
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('admin.orders.update-status', $order->order_id) }}" method="POST" class="w-100">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Telah Dibayar">
                                            <button class="btn btn-success btn-sm w-100">Konfirmasi</button>
                                        </form>
                                        <form action="{{ route('admin.orders.update-status', $order->order_id) }}" method="POST" class="w-100">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Dibatalkan">
                                            <button class="btn btn-danger btn-sm w-100">Batalkan</button>
                                        </form>
                                    </div>
                                @elseif($statusKey === 'Telah Dibayar')
                                    <form action="{{ route('admin.orders.update-status', $order->order_id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Sedang Dikemas">
                                        <button class="btn btn-primary btn-sm w-100">Tandai Sebagai Dikemas</button>
                                    </form>
                                @elseif($statusKey === 'Sedang Dikemas')
                                    <form action="{{ route('admin.orders.update-status', $order->order_id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Dikirim">
                                        <button class="btn btn-warning btn-sm w-100">Tandai Sebagai Dikirim</button>
                                    </form>
                                @elseif($statusKey === 'Dikirim')
                                    <form action="{{ route('admin.orders.update-status', $order->order_id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Selesai">
                                        <button class="btn btn-success btn-sm w-100">Tandai Sebagai Selesai</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .order-card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: 0.3s ease-in-out;
    }
    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
