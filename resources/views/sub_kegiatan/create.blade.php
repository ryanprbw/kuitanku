<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Sub Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('sub_kegiatan.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="kegiatan_id" class="block text-sm font-medium text-gray-700">Kegiatan</label>
                            <select name="kegiatan_id" id="kegiatan_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih Kegiatan --</option>
                                @foreach ($kegiatans as $kegiatan)
                                    <option value="{{ $kegiatan->id }}" data-anggaran="{{ $kegiatan->anggaran }}" {{ old('kegiatan_id') == $kegiatan->id ? 'selected' : '' }}>
                                        {{ $kegiatan->nama_kegiatan }}
                                    </option>
                                @endforeach
                            </select>
                            <p id="sisa-anggaran-kegiatan" class="mt-2 text-sm text-gray-600"></p>
                            
                    
                            @error('kegiatan_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bidang_id" class="block text-sm font-medium text-gray-700">Bidang</label>
                            <select name="bidang_id" id="bidang_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih Bidang --</option>
                                @foreach ($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}" {{ old('bidang_id') == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama_bidang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bidang_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nama_sub_kegiatan" class="block text-sm font-medium text-gray-700">Nama Sub Kegiatan</label>
                            <input type="text" name="nama_sub_kegiatan" id="nama_sub_kegiatan" value="{{ old('nama_sub_kegiatan') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('nama_sub_kegiatan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="anggaran" class="block text-sm font-medium text-gray-700">Anggaran</label>
                            <input type="number" name="anggaran" id="anggaran" value="{{ old('anggaran') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('anggaran')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Ambil elemen dropdown Kegiatan dan label untuk menampilkan sisa anggaran
            const kegiatanDropdown = document.getElementById('kegiatan_id');
            const sisaAnggaranLabel = document.getElementById('sisa-anggaran-kegiatan');
    
            // Tambahkan event listener untuk perubahan dropdown
            kegiatanDropdown.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex]; // Option yang dipilih
                const anggaran = selectedOption.getAttribute('data-anggaran'); // Ambil data-anggaran
    
                // Jika anggaran tersedia, tampilkan; jika tidak, kosongkan label
                if (anggaran) {
                    sisaAnggaranLabel.textContent = `Sisa Anggaran: Rp ${parseFloat(anggaran).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                } else {
                    sisaAnggaranLabel.textContent = '';
                }
            });
        });
    </script>
</x-app-layout>
