<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Sub Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('sub_kegiatan.update', $subKegiatan->id) }}" method="POST" class="space-y-4"
                        id="sub-kegiatan-form">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="kegiatan_id" class="block text-sm font-medium text-gray-700">Kegiatan</label>
                            <select name="kegiatan_id" id="kegiatan_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih Kegiatan --</option>
                                @foreach ($kegiatans as $kegiatan)
                                    <option value="{{ $kegiatan->id }}"
                                        {{ old('kegiatan_id', $subKegiatan->kegiatan_id) == $kegiatan->id ? 'selected' : '' }}>
                                        {{ $kegiatan->nama_kegiatan }}
                                    </option>
                                @endforeach
                            </select>
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
                                        {{ old('bidang_id', $subKegiatan->bidang_id) == $bidang->id ? 'selected' : '' }}>
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
                                value="{{ old('nama_sub_kegiatan', $subKegiatan->nama_sub_kegiatan) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('nama_sub_kegiatan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="anggaran_awal" class="block text-sm font-medium text-gray-700">Anggaran
                                Awal</label>
                            <input type="number" name="anggaran_awal" id="anggaran_awal"
                                value="{{ old('anggaran_awal', $subKegiatan->anggaran_awal) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('anggaran_awal')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="anggaran" class="block text-sm font-medium text-gray-700">Anggaran</label>
                            <input type="number" name="anggaran" id="anggaran"
                                value="{{ old('anggaran', $subKegiatan->anggaran) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('anggaran')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p id="anggaran_error" class="text-red-500 text-sm mt-1 hidden">Anggaran tidak boleh lebih
                                besar dari anggaran awal.</p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                                id="submit-button">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const anggaranField = document.getElementById('anggaran');
        const anggaranAwalField = document.getElementById('anggaran_awal');
        const anggaranError = document.getElementById('anggaran_error');
        const submitButton = document.getElementById('submit-button');

        function checkAnggaran() {
            const anggaran = parseFloat(anggaranField.value) || 0;
            const anggaranAwal = parseFloat(anggaranAwalField.value) || 0;

            if (anggaran > anggaranAwal) {
                anggaranError.classList.remove('hidden');
                submitButton.disabled = true;
            } else {
                anggaranError.classList.add('hidden');
                submitButton.disabled = false;
            }
        }

        anggaranField.addEventListener('input', checkAnggaran);
        anggaranAwalField.addEventListener('input', checkAnggaran);
        checkAnggaran();
    </script>
</x-app-layout>
