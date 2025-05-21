@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Kelola Vouchers</h1>
    <a href="{{ route('admin.voucher.create') }}" class="btn btn-primary mb-4">Create New Voucher</a>

    <div class="row">
        @foreach ($vouchers as $voucher)
            @php
                $isExpired = \Carbon\Carbon::now()->gt($voucher->end_date);
            @endphp
            <div class="col-md-6 mb-4">
                <div class="card position-relative {{ $isExpired ? 'bg-light text-muted' : '' }}">
                    <div class="card-body p-0">
                        <!-- Voucher Image Wrapper -->
                        <div class="position-relative">
                            @if ($isExpired)
                                <div class="voucher-badge">Expired</div>
                            @endif                        
                            @if ($voucher->promotion_item)
                                <img src="{{ asset('storage/' . $voucher->promotion_item) }}" alt="{{ $voucher->name }}" 
                                     class="img-fluid rounded" 
                                     style="max-height: 200px; width: 100%; object-fit: cover; {{ $isExpired ? 'filter: grayscale(70%)' : '' }}">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <span class="text-muted">No Image</span>
                                </div>
                            @endif
            
                            <!-- Hamburger Button (Dropdown) -->
                            <div class="dropdown position-absolute" style="bottom: 10px; right: 10px;">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $voucher->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $voucher->id }}">
                                    <li>
                                        <form action="{{ route('admin.voucher.destroy', ['voucher' => $voucher->vouchers_id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this voucher?')">
                                                <i class="fas fa-trash me-2"></i>Delete
                                            </button>
                                        </form>                                        
                                    </li>
                                </ul>
                            </div>
                        </div> <!-- End of Image Wrapper -->
                    </div>
                </div>
            </div>
        @endforeach
        <!-- Pagination -->
        <div class="mt-5">
            <div class="d-flex justify-content-center">
                {{ $vouchers->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<style>
    .voucher-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: #dc3545;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        z-index: 10;
    }
    /* Pagination Styles */
.pagination {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 0.5rem;
    }

    .pagination .page-item {
        flex-shrink: 0;
    }

.pagination .page-link {
    border-radius: 50px;
    padding: 0.375rem 0.75rem;
    font-size: 0.9rem;
    margin: 0 2px;
    color: #198754; /* Bootstrap green */
    border: 1px solid #dee2e6;
}

.pagination .page-item.active .page-link {
    background-color: #198754;
    border-color: #198754;
    color: #fff;
}

.pagination .page-item.disabled .page-link {
    color: #ccc;
}
</style>
@endsection
