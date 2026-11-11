<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PeminjamanController extends Controller
{
    private function dataPeminjaman()
    {
        return DB::table('peminjamans')
            ->join('bukus', 'bukus.id', '=', 'peminjamans.buku_id')
            ->select('peminjamans.*', 'bukus.judul')
            ->orderByDesc('peminjamans.id')
            ->get();
    }

    public function index()
    {
        return view('peminjaman.index', [
            'judul' => 'Data Peminjaman',
            'data' => $this->dataPeminjaman(),
        ]);
    }

    public function pengembalian()
    {
        return view('peminjaman.index', [
            'judul' => 'Data Pengembalian',
            'data' => $this->dataPeminjaman(),
        ]);
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        Gate::authorize('view', $peminjaman); // 403 bila bukan pemilik / petugas / admin

        $judulBuku = \App\Models\Buku::find($peminjaman->buku_id)?->judul;

        return view('peminjaman.show', compact('peminjaman', 'judulBuku'));
    }

    // riwayat milik akun yang sedang login
    public function riwayatSaya(Request $request)
    {
        return $this->tampilRiwayat($request->user()->anggota);
    }

    // riwayat anggota tertentu (menggunakan Policy)
    public function riwayat(Anggota $anggota)
    {
        Gate::authorize('view', $anggota);

        return $this->tampilRiwayat($anggota);
    }

    private function tampilRiwayat(?Anggota $anggota)
    {
        $data = collect();

        if ($anggota) {
            $data = DB::table('peminjamans')
                ->join('bukus', 'bukus.id', '=', 'peminjamans.buku_id')
                ->where('peminjamans.anggota_id', $anggota->id)
                ->select('peminjamans.*', 'bukus.judul')
                ->orderByDesc('peminjamans.id')
                ->get();
        }

        return view('riwayat.index', compact('anggota', 'data'));
    }
}