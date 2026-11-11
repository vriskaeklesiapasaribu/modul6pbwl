<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Buku</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('sukses'))
                <p class="rounded bg-green-100 p-3 text-green-700">{{ session('sukses') }}</p>
            @endif
            @if (session('gagal'))
                <p class="rounded bg-red-100 p-3 text-red-700">{{ session('gagal') }}</p>
            @endif

            @can('kelola-buku')
                <a href="{{ route('buku.create') }}"
                   class="inline-block rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">+ Tambah Buku</a>
            @endcan

            <div class="overflow-x-auto rounded-lg bg-white shadow-sm">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="p-3">Kategori</th>
                            <th class="p-3">Judul</th>
                            <th class="p-3">Penulis</th>
                            <th class="p-3">Tahun</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buku as $item)
                            <tr class="border-t">
                                <td class="p-3">{{ $item->kategori?->nama }}</td>
                                <td class="p-3">{{ $item->judul }}</td>
                                <td class="p-3">{{ $item->penulis }}</td>
                                <td class="p-3">{{ $item->tahun_terbit }}</td>
                                <td class="flex items-center gap-3 p-3">
                                    <a class="text-blue-600 hover:underline" href="{{ route('buku.show', $item->id) }}">Detail</a>

                                    @can('kelola-buku')
                                        <a class="text-yellow-600 hover:underline" href="{{ route('buku.edit', $item) }}">Ubah</a>

                                        <form method="POST" action="{{ route('buku.destroy', $item) }}"
                                              onsubmit="return confirm('Hapus buku ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $buku->links() }}
        </div>
    </div>
</x-app-layout>