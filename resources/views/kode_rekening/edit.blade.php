<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kode Rekening') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 mt-4">
        <!-- View Edit SKPD -->
        <form action="{{ route('skpd.update', $skpd->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label for="nama_skpd">Nama SKPD</label>
                <input type="text" name="nama_skpd" value="{{ old('nama_skpd', $skpd->nama_skpd) }}" required>
            </div>

            <div>
                <label for="anggaran_awal">Anggaran Awal</label>
                <input type="number" name="anggaran_awal" value="{{ old('anggaran_awal', $skpd->anggaran_awal) }}"
                    required readonly>
            </div>

            <div>
                <label for="anggaran">Anggaran</label>
                <input type="number" name="anggaran" value="{{ old('anggaran', $skpd->anggaran) }}" required>
            </div>

            <button type="submit">Update</button>
        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const subKegiatanDropdown = document.getElementById('sub_kegiatan_id');
            const anggaranField = document.getElementById('anggaran');
            const anggaranAwalField = document.getElementById('anggaran_awal');
            const sisaAnggaranLabel = document.getElementById('sisa-anggaran-sub-kegiatan');
            const anggaranError = document.getElementById('anggaran_error');
            const submitButton = document.getElementById('submit-button');

            // Set initial anggaran saat halaman dimuat
            function updateSisaAnggaran() {
                const selectedOption = subKegiatanDropdown.options[subKegiatanDropdown.selectedIndex];
                const anggaran = selectedOption.getAttribute('data-anggaran') || 0;

                sisaAnggaranLabel.textContent =
                    `Sisa Anggaran: Rp ${parseFloat(anggaran).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

                // Update anggaran awal dengan nilai yang sesuai
                anggaranAwalField.value = parseFloat(anggaran);
                validateAnggaran();
            }

            function validateAnggaran() {
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

            // Set initial anggaran saat halaman dimuat
            updateSisaAnggaran();

            // Update sisa anggaran saat dropdown berubah
            subKegiatanDropdown.addEventListener('change', updateSisaAnggaran);
            anggaranField.addEventListener('input', validateAnggaran);
        });
    </script>
</x-app-layout>
