<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Peminjaman') }} #{{ $peminjaman->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Peminjaman</h3>
                <div class="grid grid-cols-2 gap-4 border-t pt-4">
                    <div>
                        <span class="text-gray-500 text-sm">ID Peminjaman</span>
                        <p class="font-medium text-gray-800">{{ $peminjaman->id }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Nama Peminjam / Anggota</span>
                        <p class="font-medium text-gray-800">{{ $peminjaman->anggota->nama ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Email Anggota</span>
                        <p class="font-medium text-gray-800">{{ $peminjaman->anggota->email ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Judul Buku</span>
                        <p class="font-medium text-gray-800">{{ $peminjaman->buku->judul ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Tanggal Pinjam</span>
                        <p class="font-medium text-gray-800">{{ $peminjaman->tanggal_pinjam }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Tanggal Kembali</span>
                        <p class="font-medium text-gray-800">{{ $peminjaman->tanggal_kembali ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                        &larr; Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
