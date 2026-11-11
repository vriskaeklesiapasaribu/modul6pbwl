<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->orderBy('id', 'asc')->get();

        return view('buku.index', compact('buku'));
    }

    // Daftar buku yang dirender di server (dipakai A1)
    public function daftar()
    {
        $buku = Buku::with('kategori')->latest('id')->paginate(10);

        return view('buku.daftar', compact('buku'));
    }

    public function create()
    {
        $kategoris = Kategori::all();

        return view('buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'tahun_terbit' => 'required|integer',
        ]);

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);

        if (! $buku) {
            abort(404, 'Buku tidak ditemukan');
        }

        return view('buku.detail', compact('buku'));
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::all();

        return view('buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'tahun_terbit' => 'required|integer',
        ]);

        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->peminjamans()->exists()) {
            return redirect()->route('buku.index')
                ->with('gagal', 'Buku tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        $buku->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Buku berhasil dihapus']);
        }

        return redirect()->route('buku.index')->with('sukses', 'Buku berhasil dihapus.');
    }

    // A2: query digabung langsung ke string SQL
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select("SELECT * FROM bukus WHERE judul = '$judul'");

        return response()->json($hasil);
    }
}