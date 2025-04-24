@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Vouchers</h1>
    <a href="{{ route('admin.voucher.create') }}" class="btn btn-primary mb-4">Create New Voucher</a>

    <div class="row">
        @foreach ($vouchers as $voucher)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body p-0">
                        <!-- Voucher Image Wrapper -->
                        <div class="position-relative">
                            @if ($voucher->promotion_item)
                                <img src="{{ asset('storage/' . $voucher->promotion_item) }}" alt="{{ $voucher->name }}" class="img-fluid rounded" style="max-height: 200px; width: 100%; object-fit: cover;">
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
                                        <a class="dropdown-item" href="{{ route('admin.voucher.edit', ['voucher' => $voucher->vouchers_id]) }}">
                                            <i class="fas fa-edit me-2"></i>Edit
                                        </a>                                                                               
                                    </li>
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
    </div>
</div>
@endsection

<!-- Add Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Add Bootstrap JS for Dropdown -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
