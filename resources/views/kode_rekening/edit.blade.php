<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kode Rekening') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 mt-4">
        <form action="{{ route('kode_rekening.update', $kodeRekening->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="sub_kegiatan_id" class="block text-sm font-medium text-gray-700">Sub Kegiatan</label>
                <select name="sub_kegiatan_id" id="sub_kegiatan_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    @foreach ($subKegiatans as $subKegiatan)
                        <option value="{{ $subKegiatan->id }}" data-anggaran="{{ $subKegiatan->anggaran }}" {{ $kodeRekening->sub_kegiatan_id == $subKegiatan->id ? 'selected' : '' }}>
                            {{ $subKegiatan->nama_sub_kegiatan }}
                        </option>
                    @endforeach
                </select>
                <small id="sisa-anggaran-sub-kegiatan" class="text-sm text-gray-500 mt-2"></small>
            </div>

            <div class="mb-4">
                <label for="bidang_id" class="block text-sm font-medium text-gray-700">Bidang</label>
                <select name="bidang_id" id="bidang_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    @foreach ($bidangs as $bidang)
                        <option value="{{ $bidang->id }}" {{ $kodeRekening->bidang_id == $bidang->id ? 'selected' : '' }}>
                            {{ $bidang->nama_bidang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="nama_kode_rekening" class="block text-sm font-medium text-gray-700">Nama Kode Rekening</label>
                <input type="text" name="nama_kode_rekening" id="nama_kode_rekening" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $kodeRekening->nama_kode_rekening }}" required>
            </div>

            <div class="mb-4">
                <label for="anggaran" class="block text-sm font-medium text-gray-700">Anggaran</label>
                <input type="number" name="anggaran" id="anggaran" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $kodeRekening->anggaran }}" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const subKegiatanDropdown = document.getElementById('sub_kegiatan_id');
            const sisaAnggaranLabel = document.getElementById('sisa-anggaran-sub-kegiatan');

            // Set initial anggaran saat halaman dimuat
            const initialOption = subKegiatanDropdown.options[subKegiatanDropdown.selectedIndex];
            const initialAnggaran = initialOption.getAttribute('data-anggaran');
            if (initialAnggaran) {
                sisaAnggaranLabel.textContent = `Sisa Anggaran: Rp ${parseFloat(initialAnggaran).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            }

            // Update sisa anggaran saat dropdown berubah
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
