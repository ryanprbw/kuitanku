<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('barang.update', $barang->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nama Barang -->
                        <div class="mb-4">
                            <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                            <input type="text" name="nama_barang" id="nama_barang"
                                value="{{ old('nama_barang', $barang->nama_barang) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('nama_barang')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga Satuan -->
                        <div class="mb-4">
                            <label for="harga_satuan" class="block text-sm font-medium text-gray-700">Harga
                                Satuan</label>
                            <input type="number" step="0.01" name="harga_satuan" id="harga_satuan"
                                value="{{ old('harga_satuan', $barang->harga_satuan) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('harga_satuan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jumlah -->
                        <div class="mb-4">
                            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', $barang->jumlah) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('jumlah')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nilai Saldo -->
                        <div class="mb-4">
                            <label for="nilai_saldo" class="block text-sm font-medium text-gray-700">Nilai Saldo</label>
                            <input type="number" step="0.01" name="nilai_saldo" id="nilai_saldo"
                                value="{{ old('nilai_saldo', $barang->nilai_saldo) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                readonly>
                            @error('nilai_saldo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-blue font-bold py-2 px-4 rounded">
                                Perbarui
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
            const hargaSatuanInput = document.getElementById('harga_satuan');
            const jumlahInput = document.getElementById('jumlah');
            const nilaiSaldoInput = document.getElementById('nilai_saldo');

            function calculateSaldo() {
                const hargaSatuan = parseFloat(hargaSatuanInput.value) || 0;
                const jumlah = parseInt(jumlahInput.value) || 0;
                const nilaiSaldo = hargaSatuan * jumlah;
                nilaiSaldoInput.value = nilaiSaldo.toFixed(2);
            }

            hargaSatuanInput.addEventListener('input', calculateSaldo);
            jumlahInput.addEventListener('input', calculateSaldo);
        });
    </script>
</x-app-layout>