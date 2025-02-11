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
                            <select name="kegiatan_id" id="kegiatan_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih Kegiatan --</option>
                                @foreach ($kegiatans as $kegiatan)
                                    <option value="{{ $kegiatan->id }}" data-anggaran="{{ $kegiatan->anggaran }}"
                                        {{ old('kegiatan_id') == $kegiatan->id ? 'selected' : '' }}>
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
                            <select name="bidang_id" id="bidang_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih Bidang --</option>
                                @foreach ($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}"
                                        {{ old('bidang_id') == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama_bidang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bidang_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nama_sub_kegiatan" class="block text-sm font-medium text-gray-700">Nama Sub
                                Kegiatan</label>
                            <input type="text" name="nama_sub_kegiatan" id="nama_sub_kegiatan"
                                value="{{ old('nama_sub_kegiatan') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('nama_sub_kegiatan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="anggaran_awal" class="block text-sm font-medium text-gray-700">Anggaran
                                Awal</label>
                            <input type="number" name="anggaran_awal" id="anggaran_awal"
                                value="{{ old('anggaran_awal') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('anggaran_awal')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="anggaran" class="block text-sm font-medium text-gray-700">Anggaran</label>
                            <input type="number" name="anggaran" id="anggaran" value="{{ old('anggaran') }}" required
                                readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('anggaran')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const kegiatanDropdown = document.getElementById('kegiatan_id');
            const sisaAnggaranLabel = document.getElementById('sisa-anggaran-kegiatan');

            kegiatanDropdown.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const anggaran = selectedOption.getAttribute('data-anggaran');

                if (anggaran && !isNaN(anggaran)) {
                    sisaAnggaranLabel.textContent =
                        `Sisa Anggaran: Rp ${parseFloat(anggaran).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                } else {
                    sisaAnggaranLabel.textContent = 'Anggaran tidak tersedia.';
                }
            });
        });
    </script>

    <script>
        document.getElementById('anggaran_awal').addEventListener('input', function() {
            let anggaranAwal = parseFloat(this.value) || 0;
            const kegiatanDropdown = document.getElementById('kegiatan_id');
            const selectedOption = kegiatanDropdown.options[kegiatanDropdown.selectedIndex];
            const sisaAnggaran = parseFloat(selectedOption.getAttribute('data-anggaran')) || 0;

            if (anggaranAwal > sisaAnggaran) {
                alert('Anggaran awal tidak boleh melebihi sisa anggaran kegiatan.');
                this.value = sisaAnggaran;
                anggaranAwal = sisaAnggaran;
            }

            document.getElementById('anggaran').value = anggaranAwal;
        });
    </script>
</x-app-layout>
