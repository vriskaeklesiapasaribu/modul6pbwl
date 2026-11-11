<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $buku->exists ? 'Ubah Buku' : 'Tambah Buku' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">

                @if ($errors->any())
                    <ul class="mb-4 rounded bg-red-100 p-3 text-sm text-red-700">
                        @foreach ($errors->all() as $pesan)
                            <li>{{ $pesan }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST"
                      action="{{ $buku->exists ? route('buku.update', $buku) : route('buku.store') }}"
                      class="space-y-4">
                    @csrf
                    @if ($buku->exists)
                        @method('PUT')
                    @endif

                    <div>
                        <label class="text-sm">Kategori</label>
                        <select name="kategori_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">-- Pilih kategori --</option>
                            @foreach ($kategoris as $k)
                                <option value="{{ $k->id }}" @selected(old('kategori_id', $buku->kategori_id) == $k->id)>
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm">Judul</label>
                        <input name="judul" value="{{ old('judul', $buku->judul) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="text-sm">Penulis</label>
                        <input name="penulis" value="{{ old('penulis', $buku->penulis) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="text-sm">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Simpan</button>
                        <a href="{{ route('buku.index') }}" class="rounded border px-4 py-2">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>