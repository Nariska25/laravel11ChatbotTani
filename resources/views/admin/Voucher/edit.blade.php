@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Edit Voucher</h1>

    <form action="{{ route('admin.voucher.update', $voucher->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $voucher->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $voucher->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="promotion_code" class="form-label">Promotion Code</label>
            <input type="text" class="form-control" id="promotion_code" name="promotion_code" value="{{ old('promotion_code', $voucher->promotion_code) }}" required>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $voucher->start_date) }}" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $voucher->end_date) }}" required>
        </div>
        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', $voucher->start_time) }}" required>
        </div>
        <div class="mb-3">
            <label for="use_quantity" class="form-label">Use Quantity</label>
            <input type="number" class="form-control" id="use_quantity" name="use_quantity" value="{{ old('use_quantity', $voucher->use_quantity) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Promotion Type</label>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="promotion_type" id="special_price" value="Special Price" {{ old('promotion_type', $voucher->promotion_type) == 'Special Price' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="special_price">Special Price</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="promotion_type" id="cashback" value="Cashback" {{ old('promotion_type', $voucher->promotion_type) == 'Cashback' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="cashback">Cashback</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="promotion_type" id="buy_item_get_item" value="Buy Item get Item" {{ old('promotion_type', $voucher->promotion_type) == 'Buy Item get Item' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="buy_item_get_item">Buy Item get Item</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="promotion_item" class="form-label">Promotion Item Image</label>
            <input type="file" class="form-control" id="promotion_item" name="promotion_item">
            @if($voucher->promotion_item)
                <img src="{{ asset('storage/' . $voucher->promotion_item) }}" alt="Current Image" class="mt-2" width="100">
            @endif
        </div>
        <div class="mb-3">
            <label for="special_price" class="form-label">Special Price</label>
            <input type="number" class="form-control" id="special_price" name="special_price" value="{{ old('special_price', $voucher->special_price) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Voucher</button>
    </form>
</div>
@endsection

