<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Mutasi Barang') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Form Filter -->
            <!-- Tambahkan sebelum select barang -->


            <div class="bg-white p-6 rounded shadow mb-6">
                <form method="GET" action="{{ route('barang.mutasi') }}">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <!-- Filter Bidang -->
                        <div>
                            <label for="bidang_id" class="block text-sm font-medium text-gray-700">Bidang</label>
                            <select name="bidang_id" id="bidang_id" class="w-full rounded border-gray-300">
                                <option value="">-- Semua Bidang --</option>
                                @foreach ($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}"
                                        {{ $bidang->id == $bidangId ? 'selected' : '' }}>
                                        {{ $bidang->nama_bidang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Barang -->
                        <div>
                            <label for="barang_id" class="block text-sm font-medium text-gray-700">Barang</label>
                            <select name="barang_id" id="barang_id" class="w-full rounded border-gray-300">
                                <option value="">-- Semua Barang --</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->id }}"
                                        {{ $barang->id == $barangId ? 'selected' : '' }}>
                                        {{ $barang->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal Awal -->
                        <div>
                            <label for="tanggal_awal" class="block text-sm font-medium text-gray-700">Tanggal
                                Awal</label>
                            <input type="date" name="tanggal_awal" id="tanggal_awal" value="{{ $tanggalAwal }}"
                                class="w-full rounded border-gray-300">
                        </div>

                        <!-- Tanggal Akhir -->
                        <div>
                            <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700">Tanggal
                                Akhir</label>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ $tanggalAkhir }}"
                                class="w-full rounded border-gray-300">
                        </div>

                        <!-- Tombol Tampilkan -->
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>


            <!-- Tabel Mutasi -->
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Data Mutasi</h3>
                <table class="min-w-full border-collapse border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">Tanggal</th>
                            <th class="border px-4 py-2">Bidang</th>
                            <th class="border px-4 py-2">Barang</th>
                            <th class="border px-4 py-2">Mutasi Tambah</th>
                            <th class="border px-4 py-2">Mutasi Keluar</th>
                            <th class="border px-4 py-2">Harga Satuan</th>
                            <th class="border px-4 py-2">Jumlah</th>
                            <th class="border px-4 py-2">Nilai Saldo</th>
                            <th class="border px-4 py-2">Sisa Saldo</th>
                            <th class="border px-4 py-2">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($detailBarangs as $item)
                            <tr>
                                <td class="border px-4 py-2">{{ $item->tanggal }}</td>
                                <td class="border px-4 py-2">
                                    {{ optional($item->barang?->bidang)->nama_bidang ?? '-' }}
                                </td>

                                <td class="border px-4 py-2">{{ $item->barang->nama_barang }}</td>
                                <td class="border px-4 py-2 text-center">{{ $item->mutasi_tambah }}</td>
                                <td class="border px-4 py-2 text-center">{{ $item->mutasi_keluar }}</td>
                                <td class="border px-4 py-2 text-right">{{ number_format($item->harga_satuan, 2) }}
                                </td>
                                <td class="border px-4 py-2 text-center">{{ $item->jumlah }}</td>
                                <td class="border px-4 py-2 text-right">{{ number_format($item->nilai_saldo, 2) }}</td>
                                <td class="border px-4 py-2 text-center">{{ $item->sisa_saldo_barang }}</td>
                                <td class="border px-4 py-2">{{ $item->keterangan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="border px-4 py-2 text-center text-gray-500">
                                    Tidak ada data untuk tanggal dan barang yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
