@extends('layouts.app')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row">
        <div class="col-md-8">
            <!-- Shipping Address Section -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Shipping Address</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Phone:</strong> {{ $user->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Address:</strong> {{ $user->address }}</p>
                            <p><strong>Postal Code:</strong> {{ $user->postal_code }}</p>
                            <p><strong>City:</strong> {{ $user->city }}</p>
                            <p><strong>Province:</strong> {{ $user->province }}</p>
                        </div>
                    </div>
                    <a href="{{ route('profile.editalamat', ['redirect' => route('checkout.index', ['selected_products' => request('selected_products')])]) }}" class="btn btn-sm btn-primary">
                        Edit Alamat
                    </a>                                                                      
                </div>
            </div>

            <!-- Shipping Method Section -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Shipping Method</h5>
                </div>
                <div class="card-body">
                    <form id="shippingForm">
                        @csrf
                        <div class="form-group">
                            <label for="shipping_method" class="font-weight-bold">Select Courier & Service</label>
                            <select name="shipping_method" id="shipping_method" class="form-control" required>
                                <option value="" selected disabled>-- Select Courier --</option>
                                @foreach($shippingMethods as $method)
                                    <option 
                                        value="{{ $method->shipping_methods_id }}"
                                        data-cost="{{ $method->cost }}"
                                        data-name="{{ $method->courier }} - {{ $method->courier_service }}"
                                    >
                                        {{ strtoupper($method->courier) }} - {{ $method->courier_service }} 
                                        (Rp {{ number_format($method->cost, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted mt-2">
                                Shipping cost will be added to your total payment.
                            </small>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Payment Method Section -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Payment Method</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="xenditPayment" name="paymentMethod" 
                                   class="custom-control-input" value="xendit" checked>
                            <label class="custom-control-label font-weight-bold" for="xenditPayment">
                                Online Payment (Xendit)
                            </label>
                            <small class="form-text text-muted d-block">
                                Pay with bank transfer, e-wallet, or virtual account
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Order Summary -->
            <div class="card mb-4 sticky-top" style="top: 20px;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                    <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                        <div>
                            <h6 class="my-0">{{ $item->product->products_name }}</h6>
                            <small class="text-muted">
                                Qty: {{ $item->amount }} × Rp {{ number_format($item->product->price, 0, ',', '.') }}
                            </small>
                        </div>
                        <span class="text-muted">Rp {{ number_format($item->product->price * $item->amount, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
            
                    <!-- Voucher Section -->
                    <div class="pt-3">
                        @if($vouchers->count())
                        <div class="mb-3">
                            <label class="font-weight-bold">Voucher Tersedia:</label>
                            <div class="row">
                                @foreach($vouchers as $voucher)
                                <div class="col-12 mb-2">
                                    <div class="border rounded p-2 d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $voucher->promotion_code }}</strong><br>
                                            <small>Diskon: Rp {{ number_format($voucher->discount, 0, ',', '.') }}</small>
                                            @if($voucher->minimum_purchase)
                                            <br><small class="text-muted">Min. pembelian: Rp {{ number_format($voucher->minimum_purchase, 0, ',', '.') }}</small>
                                            @endif
                                        </div>
                                        <button 
                                            type="button" 
                                            class="btn btn-sm btn-outline-success apply-voucher-btn" 
                                            data-code="{{ $voucher->promotion_code }}"
                                        >
                                            Gunakan
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="voucherCode" placeholder="Voucher code">
                        </div>
                        <div id="voucherMessage" class="small"></div>
                    </div>
                    <hr>
                    
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Subtotal</span>
                            <span id="subtotalDisplay">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Shipping (<span id="shippingServiceLabel">-</span>)</span>
                            <span id="shippingCostDisplay">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Discount</span>
                            <span id="discountDisplay">Rp 0</span>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between font-weight-bold mt-3 pt-2 border-top">
                        <span>Total</span>
                        <span id="totalPaymentDisplay">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <form id="checkoutForm" action="{{ route('checkout.placeOrder') }}" method="POST">
                        @csrf
                        <input type="hidden" name="shipping_method_id" id="shippingMethodInput">
                        <input type="hidden" name="shipping_cost" id="shippingCostInput">
                        <input type="hidden" name="shipping_service" id="shippingServiceInput">
                        <input type="hidden" name="voucher_code" id="voucherCodeInput">
                        <input type="hidden" name="voucher_discount" id="voucherDiscountInput">
                        <input type="hidden" name="voucher_id" id="voucherIdInput">
                        <input type="hidden" name="payment_method" value="xendit">
                        <input type="hidden" name="selected_items" value="{{ request('selected_products') }}">
                        
                        <button type="submit" class="btn btn-success btn-block mt-4 py-2" id="placeOrderBtn">
                            <i class="fas fa-shopping-bag mr-2"></i> Checkout
                        </button>
                    </form>                               
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
document.addEventListener("DOMContentLoaded", function () {
    const shippingSelect = document.getElementById("shipping_method");
    const shippingCostDisplay = document.getElementById("shippingCostDisplay");
    const totalPaymentDisplay = document.getElementById("totalPaymentDisplay");
    const discountDisplay = document.getElementById("discountDisplay");
    const shippingServiceLabel = document.getElementById("shippingServiceLabel");
    const shippingMethodInput = document.getElementById("shippingMethodInput");
    const shippingCostInput = document.getElementById("shippingCostInput");
    const shippingServiceInput = document.getElementById("shippingServiceInput");
    const voucherDiscountInput = document.getElementById("voucherDiscountInput");
    const voucherCodeInput = document.getElementById("voucherCode");
    const voucherCodeHiddenInput = document.getElementById("voucherCodeInput");
    const voucherMessage = document.getElementById("voucherMessage");
    const checkoutForm = document.getElementById("checkoutForm");
    const voucherIdInput = document.getElementById("voucherIdInput");

    const subtotal = parseFloat("{{ $subtotal }}") || 0;
    let shippingCost = 0;
    let discountAmount = 0;

    function toNumber(str) {
        return parseFloat(str.toString().replace(/[^\d.-]/g, '')) || 0;
    }

    function formatRupiah(amount) {
        return 'Rp ' + amount.toLocaleString('id-ID');
    }

    function updateTotal() {
        const selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
        if (selectedOption && selectedOption.value !== "") {
            shippingCost = toNumber(selectedOption.dataset.cost);
            shippingMethodInput.value = selectedOption.value;
            shippingCostInput.value = shippingCost;
            shippingServiceInput.value = selectedOption.dataset.name;
            shippingServiceLabel.textContent = selectedOption.dataset.name;
        } else {
            shippingCost = 0;
            shippingMethodInput.value = "";
            shippingCostInput.value = 0;
            shippingServiceInput.value = "";
            shippingServiceLabel.textContent = "-";
        }

        const total = subtotal + shippingCost - discountAmount;
        shippingCostDisplay.textContent = formatRupiah(shippingCost);
        discountDisplay.textContent = '-' + formatRupiah(discountAmount);
        totalPaymentDisplay.textContent = formatRupiah(total);
    }

    function applyVoucher(code) {
        if (!code) {
            voucherMessage.innerHTML = '<div class="alert alert-danger p-2">Please enter a voucher code</div>';
            return;
        }

        fetch("{{ route('checkout.applyVoucher') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                voucherMessage.innerHTML = '<div class="alert alert-success p-2">' + data.message + '</div>';
                discountAmount = toNumber(data.discount);
                voucherDiscountInput.value = discountAmount;
                voucherCodeHiddenInput.value = data.voucher_code;
                voucherIdInput.value = data.voucher_id;
            } else {
                voucherMessage.innerHTML = '<div class="alert alert-danger p-2">' + data.error + '</div>';
                discountAmount = 0;
                voucherDiscountInput.value = 0;
                voucherCodeHiddenInput.value = '';
                voucherIdInput.value = '';
            }
            updateTotal();
        })
        .catch(error => {
            voucherMessage.innerHTML = '<div class="alert alert-danger p-2">Error applying voucher</div>';
            console.error('Voucher Error:', error);
        });
    }

    document.querySelectorAll(".apply-voucher-btn").forEach(button => {
        button.addEventListener("click", function () {
            const code = this.dataset.code;
            voucherCodeInput.value = code;
            applyVoucher(code);
        });
    });

    shippingSelect.addEventListener("change", updateTotal);

    checkoutForm.addEventListener("submit", function (event) {
        if (!shippingSelect.value) {
            event.preventDefault();
            alert("Please select a shipping method first!");
        } else {
            updateTotal();
        }
    });

    updateTotal();
});
</script>
@endpush


