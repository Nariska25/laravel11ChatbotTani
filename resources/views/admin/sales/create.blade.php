@extends('admin.layouts.app')


@section('content')
<div class="container">
    <h2>Tambah Sale</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.sales.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="products_id" class="form-label">Produk</label>
            <select name="products_id" class="form-control" required>
                @foreach($products as $product)
                    <option value="{{ $product->products_id }}">{{ $product->products_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="discount_value" class="form-label">Nilai Diskon</label>
            <input type="number" name="discount_value" class="form-control" required min="0">
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Tanggal Berakhir</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="active">Aktif</option>
                <option value="inactive">Tidak Aktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
