@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Hero Section</h2>
        <a href="{{ route('admin.hero.create') }}" class="btn btn-primary">Tambah Hero Section</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($heroSections as $section)
                    <tr>
                        <td><img src="{{ asset('storage/' . $section->image) }}" alt="Hero Image" width="100"></td>
                        <td>{{ $section->title }}</td>
                        <td>{{ $section->description }}</td>
                        <td>{{ $section->is_active ? 'Aktif' : 'Non-Aktif' }}</td>
                        <td>
                            <form action="{{ route('admin.hero.destroy', $section->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>                            
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
