<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kepala Dinas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Filter dan Pencarian -->
                    <div class="flex justify-between items-center mb-4">
                        <form action="{{ route('kepala_dinas.index') }}" method="GET" class="flex items-center">
                            <input type="text" name="search" placeholder="Cari nama atau NIP..." 
                                class="border rounded px-4 py-2 focus:ring-blue-500 focus:border-blue-500" 
                                value="{{ request('search') }}">
                            <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">
                                Cari
                            </button>
                        </form>
                        <a href="{{ route('kepala_dinas.create') }}" 
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Tambah Kepala Dinas
                        </a>
                    </div>

                    <!-- Tabel Kepala Dinas -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse table-auto">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="px-4 py-2 border-b text-left text-gray-600">Nama</th>
                                    <th class="px-4 py-2 border-b text-left text-gray-600">NIP</th>
                                    <th class="px-4 py-2 border-b text-center text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($kepala_dinas as $kd)
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2">{{ $kd->nama }}</td>
                                        <td class="px-4 py-2">{{ $kd->nip }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <a href="{{ route('kepala_dinas.edit', $kd->id) }}" 
                                                class="text-yellow-500 hover:text-yellow-700">Edit</a> |
                                            <form action="{{ route('kepala_dinas.destroy', $kd->id) }}" method="POST" 
                                                  style="display:inline;" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-2 text-center text-gray-500">
                                            Tidak ada data kepala dinas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
