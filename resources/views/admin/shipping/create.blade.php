@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Add Shipping Method</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.shipping.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="courier">Courier Name *</label>
                    <input type="text" name="courier" id="courier" 
                           class="form-control @error('courier') is-invalid @enderror" 
                           value="{{ old('courier') }}" required>
                    @error('courier')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="courier_service">Service Name *</label>
                    <input type="text" name="courier_service" id="courier_service" 
                           class="form-control @error('courier_service') is-invalid @enderror" 
                           value="{{ old('courier_service') }}" required>
                    @error('courier_service')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="delivery_estimate">Estimate *</label>
                    <input type="text" name="delivery_estimate" id="delivery_estimate" 
                           class="form-control @error('delivery_estimate') is-invalid @enderror" 
                           value="{{ old('delivery_estimate') }}" required>
                    @error('delivery_estimate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cost">Cost *</label>
                    <input type="text" name="cost" id="cost" step="0.01" 
                           class="form-control @error('cost') is-invalid @enderror" 
                           value="{{ old('cost') }}" required>
                    @error('cost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="is_active">Status *</label>
                    <select name="is_active" id="is_active" 
                            class="form-control @error('is_active') is-invalid @enderror" required>
                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection