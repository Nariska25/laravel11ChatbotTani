@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Edit Sale</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('admin.sales.update', $sale->sales_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="discount_value" class="form-label">Nilai Diskon</label>
            <input type="number" name="discount_value" id="discount_value" class="form-control" value="{{ $sale->discount_value }}">
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Tanggal Mulai</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $sale->start_date }}">
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Tanggal Selesai</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $sale->end_date }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="active" {{ $sale->status == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ $sale->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
