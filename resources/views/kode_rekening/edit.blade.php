<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kode Rekening') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('kode_rekening.update', $kodeRekening->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="sub_kegiatan_id" class="block text-sm font-medium text-gray-700">Sub
                                Kegiatan</label>
                            <select name="sub_kegiatan_id" id="sub_kegiatan_id"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                @foreach ($subKegiatans as $subKegiatan)
                                    <option value="{{ $subKegiatan->id }}" data-anggaran="{{ $subKegiatan->anggaran }}"
                                        {{ $kodeRekening->sub_kegiatan_id == $subKegiatan->id ? 'selected' : '' }}>
                                        {{ $subKegiatan->nama_sub_kegiatan }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="sisa-anggaran-sub-kegiatan" class="text-sm text-gray-500 mt-2"></small>
                        </div>

                        <div class="mb-4">
                            <label for="bidang_id" class="block text-sm font-medium text-gray-700">Bidang</label>
                            <select name="bidang_id" id="bidang_id"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                @foreach ($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}"
                                        {{ $kodeRekening->bidang_id == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama_bidang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="nama_kode_rekening" class="block text-sm font-medium text-gray-700">Nama Kode
                                Rekening</label>
                            <input type="text" name="nama_kode_rekening" id="nama_kode_rekening"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ $kodeRekening->nama_kode_rekening }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="anggaran_awal" class="block text-sm font-medium text-gray-700">Anggaran
                                Awal</label>
                            <input type="number" name="anggaran_awal" id="anggaran_awal"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ $kodeRekening->anggaran_awal }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="anggaran" class="block text-sm font-medium text-gray-700">Anggaran</label>
                            <input type="number" name="anggaran" id="anggaran"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ $kodeRekening->anggaran }}" required>
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
        document.addEventListener('DOMContentLoaded', function() {
            const subKegiatanDropdown = document.getElementById('sub_kegiatan_id');
            const sisaAnggaranLabel = document.getElementById('sisa-anggaran-sub-kegiatan');

            function updateSisaAnggaran() {
                const selectedOption = subKegiatanDropdown.options[subKegiatanDropdown.selectedIndex];
                const anggaran = selectedOption.getAttribute('data-anggaran');
                sisaAnggaranLabel.textContent = anggaran ?
                    `Sisa Anggaran: Rp ${parseFloat(anggaran).toLocaleString('id-ID')}` : '';
            }

            subKegiatanDropdown.addEventListener('change', updateSisaAnggaran);
            updateSisaAnggaran();
        });
    </script>
</x-app-layout>
