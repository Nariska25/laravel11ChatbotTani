@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Create Voucher</h1>

    <form action="{{ route('admin.voucher.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="promotion_code" class="form-label">Promotion Code</label>
            <input type="text" class="form-control" id="promotion_code" name="promotion_code" value="{{ old('promotion_code') }}" required>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
        </div>

        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" name="start_time" id="start_time" class="form-control" required>
        </div>        

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Promotion Type</label>
            <div>
                <div>
                <input class="form-check-input" type="radio" name="promotion_type" value="percentage">
                <label class="form-check-label">Percentage</label>
                </div>
                <div>
                <input class="form-check-input" type="radio" name="promotion_type" value="fixed_amount">
                <label class="form-check-label">Fixed Amount</label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="promotion_item" class="form-label">Promotion Item Image</label>
            <input type="file" class="form-control" id="promotion_item" name="promotion_item" required>
        </div>

        <div class="mb-3">
            <label for="discount" class="form-label">Discount (%)</label>
            <input type="number" class="form-control" id="discount" name="discount" value="{{ old('discount') }}" min="0" max="100" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Voucher</button>
    </form>
</div>
@endsection
