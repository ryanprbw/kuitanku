<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Detail Barang: ' . $barang->nama_barang) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Form Edit Detail Barang -->
                    <form method="POST" action="{{ route('barang.detail.update', [$barang->id, $detailBarang->id]) }}">
                        @csrf
                        @method('PUT')

                        <!-- Tanggal -->
                        <div class="mb-4">
                            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Masuk /
                                Keluar</label>
                            <input type="date" name="tanggal" id="tanggal"
                                value="{{ old('tanggal', $detailBarang->tanggal) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('tanggal')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mutasi Tambah -->
                        <div class="mb-4">
                            <label for="mutasi_tambah" class="block text-sm font-medium text-gray-700">Mutasi
                                Tambah</label>
                            <input type="number" name="mutasi_tambah" id="mutasi_tambah"
                                value="{{ old('mutasi_tambah', $detailBarang->mutasi_tambah) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('mutasi_tambah')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mutasi Keluar -->
                        <div class="mb-4">
                            <label for="mutasi_keluar" class="block text-sm font-medium text-gray-700">Mutasi
                                Keluar</label>
                            <input type="number" name="mutasi_keluar" id="mutasi_keluar"
                                value="{{ old('mutasi_keluar', $detailBarang->mutasi_keluar) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('mutasi_keluar')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga Satuan (Readonly) -->
                        <div class="mb-4">
                            <label for="harga_satuan" class="block text-sm font-medium text-gray-700">Harga
                                Satuan</label>
                            <input type="text" name="harga_satuan" id="harga_satuan"
                                value="{{ number_format($detailBarang->harga_satuan, 2) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" readonly>
                            @error('harga_satuan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jumlah -->
                        <div class="mb-4">
                            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah"
                                value="{{ old('jumlah', $detailBarang->jumlah) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('jumlah')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nilai Saldo (Readonly) -->
                        <div class="mb-4">
                            <label for="nilai_saldo" class="block text-sm font-medium text-gray-700">Nilai Saldo</label>
                            <input type="text" name="nilai_saldo" id="nilai_saldo"
                                value="{{ number_format($detailBarang->nilai_saldo, 2) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" readonly>
                            @error('nilai_saldo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sisa Saldo Barang -->
                        <div class="mb-4">
                            <label for="sisa_saldo_barang" class="block text-sm font-medium text-gray-700">Sisa Saldo
                                Barang</label>
                            <input type="text" name="sisa_saldo_barang" id="sisa_saldo_barang"
                                value="{{ old('sisa_saldo_barang', $detailBarang->sisa_saldo_barang) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" readonly>
                            @error('sisa_saldo_barang')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-4">
                            <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan"
                                value="{{ old('keterangan', $detailBarang->keterangan) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('keterangan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
