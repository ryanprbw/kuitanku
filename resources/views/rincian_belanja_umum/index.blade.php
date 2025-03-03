<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rincian Belanja Umum') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Tombol Tambah Data -->
                    <div class="flex justify-between items-center mb-4">
                        <!-- <h3 class="text-lg font-medium text-gray-900">Rincian Belanja Umum</h3> -->
                        <h3 class="text-lg font-medium text-gray-900">Total Rincian: {{ $rincianBelanja->count() }}</h3>
                        <h3 class="text-lg font-semibold">Total Belanja yang digunakan : Rp
                            {{ number_format($totalAnggaran, 0, ',', '.') }}</h3>
                        <a href="{{ route('rincian_belanja_umum.create') }}"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Tambah Data
                        </a>
                    </div>
                    <form method="GET" action="{{ route('rincian_belanja_umum.index') }}" class="mb-4">
                        <div class="flex items-center gap-2 mb-4">
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search..."
                                class="px-4 py-2 border rounded-md w-1/4" />
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Cari
                            </button>
                        </div>
                    </form>

                    <!-- Tabel Data -->
                    <div class="overflow-x-auto">
                        <table class="text-xs text-gray-700 uppercase bg-gray-50 ">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-gray-700">No.</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Program</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Kegiatan</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Sub Kegiatan</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Kode Rekening</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Nama Rincian Belanja Umum</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Jumlah (Rp)</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Dibuat pada :</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Bidang</th>
                                    <th class="px-4 py-2 text-center text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($rincianBelanja as $rincian)
                                    <tr>
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $rincian->program->nama ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $rincian->kegiatan->nama_kegiatan ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $rincian->subKegiatan->nama_sub_kegiatan ?? '-' }}
                                        <td class="px-4 py-2">{{ $rincian->kodeRekening->nama_kode_rekening ?? '-' }}
                                        <td class="px-4 py-2">{{ $rincian->untuk_pengeluaran ?? '-' }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($rincian->sebesar, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2">{{ $rincian->created_at ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $rincian->bidang->nama_bidang ?? '-' }}</td>
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <a href="{{ route('rincian_belanja_umum.pdf.detail', $rincian->id) }}"
                                                class="text-yellow-500 hover:underline">Cetak Kuitansi</a>
                                            <a href="{{ route('rincian_belanja_umum.show', $rincian->id) }}"
                                                class="text-green-500 hover:underline">Detail</a>

                                            <a href="{{ route('rincian_belanja_umum.edit', $rincian->id) }}"
                                                class="text-blue-500 hover:underline ml-2">Edit</a>
                                            @if (Auth::user()->role !== 'bidang')
                                                <form
                                                    action="{{ route('rincian_belanja_umum.destroy', $rincian->id) }}"
                                                    method="POST" class="inline ml-2"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:underline">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-2 text-center text-gray-500">Tidak ada data
                                            tersedia.</td>
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
    </div>
</x-app-layout>
