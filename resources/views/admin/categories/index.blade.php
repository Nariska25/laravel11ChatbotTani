@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Kategori</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Tambah Kategori</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Deskripsi Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->nama_kategori }}</td>
                        <td>{{ $category->deskripsi_kategori ?? 'Tidak ada deskripsi' }}</td>
                        <td>
                            <form action="{{ route('admin.categories.destroy', $category->kategori_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
