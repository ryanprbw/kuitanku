<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kode Rekening') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('kode_rekening.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="sub_kegiatan_id" class="block text-sm font-medium text-gray-700">Sub Kegiatan</label>
                            <select name="sub_kegiatan_id" id="sub_kegiatan_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih Sub Kegiatan --</option>
                                @foreach ($subKegiatans as $subKegiatan)
                                    <option value="{{ $subKegiatan->id }}" data-anggaran="{{ $subKegiatan->anggaran }}" {{ old('sub_kegiatan_id') == $subKegiatan->id ? 'selected' : '' }}>
                                        {{ $subKegiatan->nama_sub_kegiatan }}
                                    </option>
                                @endforeach
                            </select>
                            <p id="sisa-anggaran-sub-kegiatan" class="mt-2 text-sm text-gray-600"></p>
                            @error('sub_kegiatan_id')
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
                            <label for="nama_kode_rekening" class="block text-sm font-medium text-gray-700">Nama Kode Rekening</label>
                            <input type="text" name="nama_kode_rekening" id="nama_kode_rekening" value="{{ old('nama_kode_rekening') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('nama_kode_rekening')
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
            const subKegiatanDropdown = document.getElementById('sub_kegiatan_id');
            const sisaAnggaranLabel = document.getElementById('sisa-anggaran-sub-kegiatan');

            subKegiatanDropdown.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const anggaran = selectedOption.getAttribute('data-anggaran');

                if (anggaran) {
                    sisaAnggaranLabel.textContent = `Sisa Anggaran: Rp ${parseFloat(anggaran).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                } else {
                    sisaAnggaranLabel.textContent = '';
                }
            });
        });
    </script>
</x-app-layout>
