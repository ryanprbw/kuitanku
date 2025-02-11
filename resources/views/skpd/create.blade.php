<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah SKPD Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Form untuk menambahkan SKPD -->
                    <form action="{{ route('skpd.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Nama SKPD -->
                        <div>
                            <label for="nama_skpd" class="block text-sm font-medium text-gray-700">Nama SKPD</label>
                            <input type="text" name="nama_skpd" id="nama_skpd" value="{{ old('nama_skpd') }}"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('nama_skpd')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Anggaran -->
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

                        <div>
                            <label for="anggaran" class="block text-sm font-medium text-gray-700">Anggaran</label>
                            <input type="number" name="anggaran" id="anggaran" value="{{ old('anggaran') }}" required
                                readonly
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-100">
                            @error('anggaran')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    document.getElementById('anggaran_awal').addEventListener('input', function() {
        document.getElementById('anggaran').value = this.value;
    });
</script>
