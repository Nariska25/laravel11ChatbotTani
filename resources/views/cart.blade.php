@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<!-- Single Page Header Start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Cart</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active text-white">Cart</li>
    </ol>
</div>
<!-- Single Page Header End -->

<!-- Cart Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Products</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carts as $cart)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $cart->produk->gambar_produk) }}" alt="{{ $cart->produk->nama_produk }}" width="100">
                            </td>
                            <td>{{ $cart->produk->nama_produk }}</td>
                            <td>Rp.{{ number_format($cart->produk->harga, 0, '.', '.') }}</td>
                            <td>{{ $cart->jumlah }}</td>
                            <td>Rp.{{ number_format($cart->jumlah * $cart->produk->harga, 0, '.', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.delete', $cart->carts_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row g-4 justify-content-end">
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded p-4">
                    <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                    @php
                        $subtotal = $carts->sum(function($cart) {
                            return $cart->produk->harga * $cart->jumlah;
                        });
                        $total = $subtotal 
                    @endphp
                    <div class="d-flex justify-content-between mb-4">
                        <h5>Subtotal:</h5>
                        <p>Rp.{{ number_format($subtotal, 0, '.', '.') }}</p>
                    </div>
                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                        <h5>Total:</h5>
                        <p>Rp.{{ number_format($total, 0, '.', '.') }}</p>
                    </div>
                    <a href="#" class="btn btn-primary rounded-pill w-100">Proceed Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart Page End -->
@endsection
