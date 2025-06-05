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
            <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
        </div>     

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" required>
        </div>
        <div class="mb-3">
            <label for="promotion_item" class="form-label">Promotion Item Image</label>
            <input type="file" class="form-control" id="promotion_item" name="promotion_item" required>
        </div>

        <div class="mb-3">
            <label for="discount" class="form-label">Discount</label>
            <input type="number" class="form-control" id="discount" name="discount" value="{{ old('discount') }}" min="0" max="100000000" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Voucher</button>
    </form>
</div>

<script>
    document.getElementById('promotion_item').addEventListener('change', function () {
        const file = this.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB dalam byte

        if (file && file.size > maxSize) {
            alert('Ukuran gambar terlalu besar. Maksimal ukuran adalah 2MB.');
            this.value = ''; // reset input file
        }
    });

    document.getElementById('start_date').addEventListener('change', function () {
        const startDate = new Date(this.value);
        if (!isNaN(startDate.getTime())) {
            // Tambah 1 hari penuh
            startDate.setDate(startDate.getDate() + 1);
            const iso = startDate.toISOString().slice(0, 16); // Format datetime-local
            document.getElementById('end_date').setAttribute('min', iso);
        }
    });
</script>

@endsection
