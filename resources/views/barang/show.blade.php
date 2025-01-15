<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Barang: ' . $barang->nama_barang) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Informasi Barang -->
                    <h3 class="text-lg font-semibold mb-4">Informasi Barang</h3>
                    <table class="min-w-full border-collapse border border-gray-200 mb-6">
                        <tr>
                            <th class="border border-gray-200 px-4 py-2">Nama Barang</th>
                            <td class="border border-gray-200 px-4 py-2">{{ $barang->nama_barang }}</td>
                        </tr>
                        <tr>
                            <th class="border border-gray-200 px-4 py-2">Harga Satuan</th>
                            <td class="border border-gray-200 px-4 py-2">{{ number_format($barang->harga_satuan, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="border border-gray-200 px-4 py-2">Jumlah</th>
                            <td class="border border-gray-200 px-4 py-2">{{ $barang->jumlah }}</td>
                        </tr>
                        <tr>
                            <th class="border border-gray-200 px-4 py-2">Nilai Saldo</th>
                            <td class="border border-gray-200 px-4 py-2">{{ number_format($barang->nilai_saldo, 2) }}
                            </td>
                        </tr>
                    </table>

                    <!-- Tombol Tambah Detail Barang -->
                    <div class="mb-4">
                        <a href="{{ route('barang.detail.create', $barang->id) }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Detail Barang
                        </a>
                    </div>

                    <!-- Tabel Detail Barang -->
                    <h3 class="text-lg font-semibold mb-4">Detail Transaksi Barang</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2">No</th>
                                    <th class="border border-gray-200 px-4 py-2">Tanggal</th>
                                    <th class="border border-gray-200 px-4 py-2">Mutasi Tambah</th>
                                    <th class="border border-gray-200 px-4 py-2">Mutasi Keluar</th>
                                    <th class="border border-gray-200 px-4 py-2">Harga Satuan</th>
                                    <th class="border border-gray-200 px-4 py-2">Jumlah</th>
                                    <th class="border border-gray-200 px-4 py-2">Nilai Saldo</th>
                                    <th class="border border-gray-200 px-4 py-2">Sisa Saldo Barang</th>
                                    <th class="border border-gray-200 px-4 py-2">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($barang->detailBarang as $index => $detail)
                                    <tr>
                                        <td class="border border-gray-200 px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $detail->tanggal }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $detail->mutasi_tambah }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $detail->mutasi_keluar }}</td>
                                        <td class="border border-gray-200 px-4 py-2">
                                            {{ number_format($detail->harga_satuan, 2) }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $detail->jumlah }}</td>
                                        <td class="border border-gray-200 px-4 py-2">
                                            {{ number_format($detail->nilai_saldo, 2) }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $detail->sisa_saldo_barang }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $detail->keterangan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="border border-gray-200 px-4 py-2 text-center">Tidak ada data
                                            transaksi untuk barang ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="mt-4">
                        <a href="{{ route('barang.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali ke Daftar Barang
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>