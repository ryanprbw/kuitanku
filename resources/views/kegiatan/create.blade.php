<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Menampilkan pesan error jika ada -->
                    @if ($errors->any())
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('kegiatan.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Nama Kegiatan -->
                        <div>
                            <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700">Nama
                                Kegiatan</label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan"
                                value="{{ old('nama_kegiatan') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('nama_kegiatan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Program -->
                        <div>
                            <label for="program_id" class="block text-sm font-medium text-gray-700">Program</label>
                            <select name="program_id" id="program_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Pilih Program --</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->id }}"
                                        {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                        {{ $program->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('program_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bidang -->
                        <div>
                            <label for="bidang_id" class="block text-sm font-medium text-gray-700">Bidang</label>
                            <select name="bidang_id" id="bidang_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
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
                        <!-- Anggaran Awal -->
                        <div>
                            <label for="anggaran_awal" class="block text-sm font-medium text-gray-700">Anggaran
                                Awal</label>
                            <input type="number" name="anggaran_awal" id="anggaran_awal"
                                value="{{ old('anggaran_awal') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('anggaran_awal')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Anggaran -->
                        <div>
                            <label for="anggaran" class="block text-sm font-medium text-gray-700">Anggaran</label>
                            <input type="number" name="anggaran" id="anggaran" value="{{ old('anggaran') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                readonly>
                            @error('anggaran')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Simpan -->
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
        // JavaScript untuk mengisi anggaran secara otomatis berdasarkan anggaran_awal
        document.getElementById('anggaran_awal').addEventListener('input', function() {
            let anggaranAwal = this.value;
            document.getElementById('anggaran').value = anggaranAwal;
        });
    </script>
</x-app-layout>
