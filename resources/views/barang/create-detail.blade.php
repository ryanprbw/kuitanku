<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Detail Barang: ' . $barang->nama_barang) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('barang.detail.store', $barang->id) }}">
                        @csrf

                        <!-- Tanggal -->
                        <div class="mb-4">
                            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('tanggal')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mutasi Tambah -->
                        <div class="mb-4">
                            <label for="mutasi_tambah" class="block text-sm font-medium text-gray-700">Mutasi
                                Tambah</label>
                            <input type="number" name="mutasi_tambah" id="mutasi_tambah"
                                value="{{ old('mutasi_tambah', 0) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('mutasi_tambah')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mutasi Keluar -->
                        <div class="mb-4">
                            <label for="mutasi_keluar" class="block text-sm font-medium text-gray-700">Mutasi
                                Keluar</label>
                            <input type="number" name="mutasi_keluar" id="mutasi_keluar"
                                value="{{ old('mutasi_keluar', 0) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('mutasi_keluar')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga Satuan -->
                        <div class="mb-4">
                            <label for="harga_satuan" class="block text-sm font-medium text-gray-700">Harga
                                Satuan</label>
                            <input type="number" step="0.01" name="harga_satuan" id="harga_satuan"
                                value="{{ $barang->harga_satuan }}" readonly
                                class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <!-- Sisa Saldo Barang -->
                        <div class="mb-4">
                            <label for="sisa_saldo_barang" class="block text-sm font-medium text-gray-700">Sisa Saldo
                                Barang</label>
                            <input type="number" name="sisa_saldo_barang" id="sisa_saldo_barang"
                                value="{{ $barang->jumlah }}" readonly
                                class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <!-- Jumlah -->
                        <div class="mb-4">
                            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="number" step="0.01" name="jumlah" id="jumlah" value="0" readonly
                                class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <!-- Nilai Saldo -->
                        <div class="mb-4">
                            <label for="nilai_saldo" class="block text-sm font-medium text-gray-700">Nilai Saldo</label>
                            <input type="number" step="0.01" name="nilai_saldo" id="nilai_saldo" value="0" readonly
                                class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-4">
                            <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mutasiTambahInput = document.getElementById('mutasi_tambah');
            const mutasiKeluarInput = document.getElementById('mutasi_keluar');
            const hargaSatuanInput = document.getElementById('harga_satuan');
            const sisaSaldoBarangInput = document.getElementById('sisa_saldo_barang');
            const jumlahInput = document.getElementById('jumlah');
            const nilaiSaldoInput = document.getElementById('nilai_saldo');

            function calculateValues() {
                const mutasiTambah = parseInt(mutasiTambahInput.value) || 0;
                const mutasiKeluar = parseInt(mutasiKeluarInput.value) || 0;
                const hargaSatuan = parseFloat(hargaSatuanInput.value) || 0;
                const sisaSaldoBarang = parseInt(sisaSaldoBarangInput.value) || 0;

                // Hitung sisa saldo setelah mutasi
                const sisaSaldoAkhir = sisaSaldoBarang + mutasiTambah - mutasiKeluar;

                // Hitung jumlah barang
                const jumlah = mutasiTambah - mutasiKeluar;

                // Hitung nilai saldo
                const nilaiSaldo = sisaSaldoAkhir * hargaSatuan;

                // Perbarui nilai di form
                jumlahInput.value = jumlah.toFixed(2);
                nilaiSaldoInput.value = nilaiSaldo.toFixed(2);
            }

            mutasiTambahInput.addEventListener('input', calculateValues);
            mutasiKeluarInput.addEventListener('input', calculateValues);
        });
    </script>
</x-app-layout>