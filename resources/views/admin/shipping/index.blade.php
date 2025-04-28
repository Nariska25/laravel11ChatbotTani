@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Shipping Methods</h5>
            <a href="{{ route('admin.shipping.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Courier</th>
                            <th>Service</th>
                            <th>Estimate</th>
                            <th>Cost</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shippingMethods as $method)
                        <tr>
                            <td>{{ $method->courier }}</td>
                            <td>{{ $method->courier_service }}</td>
                            <td>{{ $method->delivery_estimate }}</td>
                            <td>Rp {{ number_format($method->cost, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $method->is_active ? 'success' : 'danger' }}">
                                    {{ $method->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="d-flex">
                                <a href="{{ route('admin.shipping.edit', $method->shipping_methods_id) }}" 
                                    class="btn btn-sm btn-warning mr-2">
                                     <i class="fas fa-edit"></i>
                                 </a>
                                 
                                <form action="{{ route('admin.shipping.destroy', $method->shipping_methods_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No shipping methods found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection