<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rincian Belanja Umum') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Tombol Tambah Data -->
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('rincian_belanja_umum.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Data
                        </a>
                    </div>

                    <!-- Tabel Data -->
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full text-left border-collapse border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 border border-gray-200">No</th>
                                    <th class="px-4 py-2 border border-gray-200">Nama Rincian Belanja Umum</th>
                                    <th class="px-4 py-2 border border-gray-200">Program</th>
                                    <th class="px-4 py-2 border border-gray-200">Kegiatan</th>
                                    <th class="px-4 py-2 border border-gray-200">Bidang</th>
                                    <th class="px-4 py-2 border border-gray-200">Sub Kegiatan</th>
                                    <th class="px-4 py-2 border border-gray-200">Jumlah (Rp)</th>
                                    <th class="px-4 py-2 border border-gray-200">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rincianBelanja as $rincian)
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 border border-gray-200">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2 border border-gray-200">{{ $rincian->untuk_pengeluaran ?? '-' }}</td>
                                        <td class="px-4 py-2 border border-gray-200">{{ $rincian->program->nama ?? '-' }}</td>
                                        <td class="px-4 py-2 border border-gray-200">{{ $rincian->kegiatan->nama_kegiatan ?? '-' }}</td>
                                        <td class="px-4 py-2 border border-gray-200">{{ $rincian->bidang->nama_bidang ?? '-' }}</td>
                                        <td class="px-4 py-2 border border-gray-200">{{ $rincian->subKegiatan->nama_sub_kegiatan ?? '-' }}</td>
                                        <td class="px-4 py-2 border border-gray-200">{{ number_format($rincian->sebesar, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 border border-gray-200">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('rincian_belanja_umum.show', $rincian->id) }}" class="text-blue-500 hover:underline">
                                                    Detail
                                                </a>
                                                <a href="{{ route('rincian_belanja_umum.edit', $rincian->id) }}" class="text-green-500 hover:underline">
                                                    Edit
                                                </a>
                                                <form action="{{ route('rincian_belanja_umum.destroy', $rincian->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:underline">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Tidak ada data tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $rincianBelanja->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
