<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Buku</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Daftar Buku</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">Dashboard</a>
            <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm">Tambah Buku</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0 bg-white">
                <thead class="table-dark">
                    <tr>
                        <th style="width:60px" class="text-center">No</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun Terbit</th>
                        <th style="width:180px" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabelBuku">
                    @forelse ($buku as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->kategori->nama ?? '-' }}</td>
                            {{-- A1: Celah XSS - menampilkan judul tanpa escaping {!! !!} --}}
                            <td>{!! $item->judul !!}</td>
                            <td>{{ $item->penulis }}</td>
                            <td>{{ $item->tahun_terbit }}</td>
                            <td class="text-center">
                                <a href="{{ route('buku.show', $item->id) }}" class="btn btn-outline-primary btn-sm me-1">Lihat</a>
                                <a href="{{ route('buku.edit', $item->id) }}" class="btn btn-warning btn-sm me-1">Ubah</a>
                                {{-- A3: Celah CSRF - penghapusan buku melalui method GET tanpa token CSRF --}}
                                <a href="{{ url('/buku/'.$item->id.'/hapus') }}" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
