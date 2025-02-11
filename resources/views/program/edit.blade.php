<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Program') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('program.update', $program->id) }}" method="POST" class="space-y-4"
                        id="program-form">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Program</label>
                            <input type="text" name="nama" id="nama"
                                value="{{ old('nama', $program->nama) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('nama')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="skpd_id" class="block text-sm font-medium text-gray-700">SKPD</label>
                            <select name="skpd_id" id="skpd_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Pilih SKPD --</option>
                                @foreach ($skpds as $skpd)
                                    <option value="{{ $skpd->id }}"
                                        {{ old('skpd_id', $program->skpd_id) == $skpd->id ? 'selected' : '' }}>
                                        {{ $skpd->nama_skpd }}
                                    </option>
                                @endforeach
                            </select>
                            @error('skpd_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bidang_id" class="block text-sm font-medium text-gray-700">Bidang</label>
                            <select name="bidang_id" id="bidang_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Pilih Bidang --</option>
                                @foreach ($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}"
                                        {{ old('bidang_id', $program->bidang_id) == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama_bidang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bidang_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="anggaran_awal" class="block text-sm font-medium text-gray-700">Anggaran
                                Awal</label>
                            <input type="number" name="anggaran_awal" id="anggaran_awal"
                                value="{{ old('anggaran_awal', $program->anggaran_awal) }}" readonly
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('anggaran_awal')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="anggaran" class="block text-sm font-medium text-gray-700">Anggaran</label>
                            <input type="number" name="anggaran" id="anggaran"
                                value="{{ old('anggaran', $program->anggaran) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('anggaran')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p id="anggaran_error" class="text-red-500 text-sm mt-1 hidden">Anggaran tidak boleh lebih
                                besar dari anggaran awal.</p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                                id="submit-button">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Validasi anggaran agar tidak melebihi anggaran_awal
        const anggaranField = document.getElementById('anggaran');
        const anggaranAwalField = document.getElementById('anggaran_awal');
        const anggaranError = document.getElementById('anggaran_error');
        const form = document.getElementById('program-form');
        const submitButton = document.getElementById('submit-button');

        // Fungsi untuk mengecek apakah anggaran valid
        function checkAnggaran() {
            const anggaran = parseFloat(anggaranField.value);
            const anggaranAwal = parseFloat(anggaranAwalField.value);

            if (anggaran > anggaranAwal) {
                anggaranError.classList.remove('hidden');
                submitButton.disabled = true; // Menonaktifkan tombol submit
            } else {
                anggaranError.classList.add('hidden');
                submitButton.disabled = false; // Mengaktifkan tombol submit
            }
        }

        // Menambahkan event listener saat nilai anggaran berubah
        anggaranField.addEventListener('input', checkAnggaran);

        // Panggil checkAnggaran sekali untuk validasi awal
        checkAnggaran();
    </script>
</x-app-layout>
