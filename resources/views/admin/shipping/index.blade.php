@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Kelola Pengiriman</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Pengiriman</h6>
            <a href="{{ route('admin.shipping.create') }}" class="btn btn-primary">Tambah Pengiriman</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Courier</th>
                            <th>Service</th>
                            <th>Estimate</th>
                            <th>Cost</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shippingMethods as $index => $method)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $method->courier }}</td>
                            <td>{{ $method->courier_service }}</td>
                            <td>{{ $method->delivery_estimate }}</td>
                            <td>Rp {{ number_format($method->cost, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $method->is_active ? 'success' : 'danger' }}">
                                    {{ $method->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.shipping.edit', $method->shipping_methods_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.shipping.destroy', $method->shipping_methods_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data pengiriman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
