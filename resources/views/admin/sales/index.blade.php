@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Data Sales</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data Sales</h6>
            <a href="{{ route('admin.sales.create') }}" class="btn btn-primary mb-3">Tambah Sale</a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Harga Asli</th>
                        <th>Harga Diskon</th>
                        <th>Jenis Diskon</th>
                        <th>Nilai Diskon</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Berakhir</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->products->nama_produk }}</td>
                        <td>Rp. {{ number_format($sale->products->harga, 0, '.', '.') }}</td>
                        <td>
                            @if ($sale->status == 'active')
                                @php
                                    $hargaAsli = $sale->products->harga;
                                    if ($sale->discount_type == 'percentage') {
                                        $hargaDiskon = $hargaAsli - ($hargaAsli * ($sale->discount_value / 100));
                                    } else {
                                        $hargaDiskon = max(0, $hargaAsli - $sale->discount_value);
                                    }
                                @endphp
                                <span class="original-price text-decoration-line-through">
                                    Rp. {{ number_format($hargaAsli, 0, '.', '.') }}
                                </span>
                                <span class="discounted-price text-danger">
                                    Rp. {{ number_format($hargaDiskon, 0, '.', '.') }}
                                </span>
                            @else
                                <span class="discounted-price">
                                    Rp. {{ number_format($sale->products->harga, 0, '.', '.') }}
                                </span>
                            @endif
                        </td>
                        <td>{{ ucfirst($sale->discount_type) }}</td>
                        <td>
                            {{ $sale->discount_type == 'percentage' ? 
                                $sale->discount_value . '%' : 
                                'Rp ' . number_format($sale->discount_value, 0, ',', '.') 
                            }}
                        </td>
                        <td>{{ $sale->start_date }}</td>
                        <td>{{ $sale->end_date }}</td>
                        <td>{{ $sale->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}</td>
                        <td>
                            <a href="{{ route('admin.sales.edit', $sale->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.sales.destroy', $sale->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus sale ini?')">Hapus</button>
                            </form>
                        </td>                
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection