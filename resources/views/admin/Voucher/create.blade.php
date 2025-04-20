@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Create Voucher</h1>

    <form action="{{ route('admin.voucher.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="promotion_code" class="form-label">Promotion Code</label>
            <input type="text" class="form-control" id="promotion_code" name="promotion_code" required>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" required>
        </div>
        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" required>
        </div>
        <div class="mb-3">
            <label for="use_quantity" class="form-label">Use Quantity</label>
            <input type="number" class="form-control" id="use_quantity" name="use_quantity" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Promotion Type</label>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="promotion_type" id="special_price" value="Special Price" required>
                    <label class="form-check-label" for="special_price">Special Price</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="promotion_type" id="cashback" value="Cashback" required>
                    <label class="form-check-label" for="cashback">Cashback</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="promotion_type" id="buy_item_get_item" value="Buy Item get Item" required>
                    <label class="form-check-label" for="buy_item_get_item">Buy Item get Item</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="promotion_item" class="form-label">Promotion Item Image</label>
            <input type="file" class="form-control" id="promotion_item" name="promotion_item" required>
        </div>
        <div class="mb-3">
            <label for="special_price" class="form-label">Special Price</label>
            <input type="number" class="form-control" id="special_price" name="special_price" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Voucher</button>
    </form>
</div>
@endsection