<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Rincian Belanja Umum') }}
        </h2>
    </x-slot>



    <div class="container mx-auto py-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-6">Tambah Rincian Belanja Umum</h2>

            @if ($errors->any())
            <div class="mb-4 p-4 text-red-800 bg-red-200 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('rincian_belanja_umum.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Program --}}
                <div>
                    <label for="program_id" class="block mb-2 text-sm font-medium text-gray-700">Program</label>
                    <select id="program_id" name="program_id" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="" selected>Pilih Program</option>
                        @foreach ($programs as $program)
                        <option value="{{ $program->id }}">{{ $program->nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Kegiatan --}}
                <div>
                    <label for="kegiatan_id" class="block mb-2 text-sm font-medium text-gray-700">Kegiatan</label>
                    <select id="kegiatan_id" name="kegiatan_id" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="" selected>Pilih Kegiatan</option>
                        @foreach ($kegiatans as $kegiatan)
                        <option value="{{ $kegiatan->id }}">{{ $kegiatan->nama_kegiatan }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Sub Kegiatan --}}
                <div>
                    <label for="sub_kegiatan_id" class="block mb-2 text-sm font-medium text-gray-700">Sub Kegiatan</label>
                    <select id="sub_kegiatan_id" name="sub_kegiatan_id" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="" selected>Pilih Sub Kegiatan</option>
                        @foreach ($sub_kegiatans as $sub_kegiatan)
                        <option value="{{ $sub_kegiatan->id }}">{{ $sub_kegiatan->nama_sub_kegiatan }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Kode Rekening --}}
                <div>
                    <label for="kode_rekening_id" class="block mb-2 text-sm font-medium text-gray-700">Kode Rekening</label>
                    <select id="kode_rekening_id" name="kode_rekening_id" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="" selected>Pilih Kode Rekening</option>
                        @foreach ($kode_rekenings as $kode_rekening)
                        <option value="{{ $kode_rekening->id }}">{{ $kode_rekening->nama_kode_rekening }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Anggaran --}}
                <div>
                    <label for="anggaran" class="block mb-2 text-sm font-medium text-gray-700">Anggaran</label>
                    <input type="number" step="0.01" id="anggaran" name="anggaran" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200" placeholder="Masukkan anggaran">
                </div>

                {{-- Sebesar --}}
                <div>
                    <label for="sebesar" class="block mb-2 text-sm font-medium text-gray-700">Sebesar (Masukan Nilai Anggaran)</label>
                    <input type="number" step="0.01" id="sebesar" name="sebesar" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200" placeholder="Masukkan jumlah">
                </div>

                {{-- Untuk Pengeluaran --}}
                <div>
                    <label for="untuk_pengeluaran" class="block mb-2 text-sm font-medium text-gray-700">Untuk Pengeluaran</label>
                    <textarea id="untuk_pengeluaran" name="untuk_pengeluaran" rows="3" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200" placeholder="Masukkan deskripsi pengeluaran"></textarea>
                </div>

                {{-- DPP --}}
                <div>
                    <label for="dpp" class="block mb-2 text-sm font-medium text-gray-700">DPP (Dasar Pengenaan Pajak)</label>
                    <input type="number" step="0.01" id="dpp" name="dpp" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200" placeholder="Masukkan nilai DPP">
                </div>

                {{-- PPH21 --}}
                <div>
                    <label for="pph21" class="block mb-2 text-sm font-medium text-gray-700">PPH21</label>
                    <input type="number" step="0.01" id="pph21" name="pph21" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200" placeholder="Masukkan nilai PPH21">
                </div>

                {{-- PPH22 --}}
                <div>
                    <label for="pph22" class="block mb-2 text-sm font-medium text-gray-700">PPH22</label>
                    <input type="number" step="0.01" id="pph22" name="pph22" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200" placeholder="Masukkan nilai PPH22">
                </div>

                {{-- PPH23 --}}
                <div>
                    <label for="pph23" class="block mb-2 text-sm font-medium text-gray-700">PPH23</label>
                    <input type="number" step="0.01" id="pph23" name="pph23" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200" placeholder="Masukkan nilai PPH23">
                </div>
                <div>
                    <label for="ppn" class="block mb-2 text-sm font-medium text-gray-700">PPN</label>
                    <input type="number" step="0.01" id="ppn" name="ppn" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200" placeholder="Masukkan nilai PPN">
                </div>

                {{-- Kepala Dinas --}}
                <div>
                    <label for="kepala_dinas_id" class="block mb-2 text-sm font-medium text-gray-700">Kepala Dinas</label>
                    <select id="kepala_dinas_id" name="kepala_dinas_id" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="" selected>Pilih Kepala Dinas</option>
                        @foreach ($kepala_dinas as $dinas)
                        <option value="{{ $dinas->id }}">{{ $dinas->nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- PPTK --}}
                <div>
                    <label for="pptk_id" class="block mb-2 text-sm font-medium text-gray-700">PPTK</label>
                    <select id="pptk_id" name="pptk_id" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="" selected>Pilih PPTK</option>
                        @foreach ($pptks as $pptk)
                        <option value="{{ $pptk->id }}">{{ $pptk->nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Bendahara --}}
                <div>
                    <label for="bendahara_id" class="block mb-2 text-sm font-medium text-gray-700">Bendahara</label>
                    <select id="bendahara_id" name="bendahara_id" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="" selected>Pilih Bendahara</option>
                        @foreach ($bendaharas as $bendahara)
                        <option value="{{ $bendahara->id }}">{{ $bendahara->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="bulan" class="block mb-2 text-sm font-medium text-gray-700">Diterima pada Bulan</label>
                    <select id="bulan" name="bulan" class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="" disabled selected>Pilih Bulan</option>
                        <option value="Januari" {{ old('bulan', isset($rincianBelanja) ? $rincianBelanja->bulan : '') == 'Januari' ? 'selected' : '' }}>Januari</option>
                        <option value="Februari" {{ old('bulan', isset($rincianBelanja) ? $rincianBelanja->bulan : '') == 'Februari' ? 'selected' : '' }}>Februari</option>
                        <option value="Maret" {{ old('bulan', isset($rincianBelanja) ? $rincianBelanja->bulan : '') == 'Maret' ? 'selected' : '' }}>Maret</option>
                        <option value="April" {{ old('bulan', isset($rincianBelanja) ? $rincianBelanja->bulan : '') == 'April' ? 'selected' : '' }}>April</option>
                        <option value="Mei" {{ old('bulan', isset($rincianBelanja) ? $rincianBelanja->bulan : '') == 'Mei' ? 'selected' : '' }}>Mei</option>
                        <option value="Juni" {{ old('bulan', isset($rincianBelanja) ? $rincianBelanja->bulan : '') == 'Juni' ? 'selected' : '' }}>Juni</option>
                        <option value="Juli" {{ old('bulan', isset($rincianBelanja) ? $rincianBelanja->bulan : '') == 'Juli' ? 'selected' : '' }}>Juli</option>
                        <option value="Agustus" {{ old('bulan', isset($rincianBelanja) ? $rincianBelanja->bulan : '') == 'Agustus' ? 'selected' : '' }}>Agustus</option>
                        <option value="September" {{ old('bulan', isset($rincianBelanja) ? $rincianBelanja->bulan : '') == 'September' ? 'selected' : '' }}>September</option>
                        <option value="Oktober" {{ old('bulan', isset($rincianBelanja) ? $rincianBelanja->bulan : '') == 'Oktober' ? 'selected' : '' }}>Oktober</option>
                        <option value="November" {{ old('bulan', isset($rincianBelanja) ? $rincianBelanja->bulan : '') == 'November' ? 'selected' : '' }}>November</option>
                        <option value="Desember" {{ old('bulan', isset($rincianBelanja) ? $rincianBelanja->bulan : '') == 'Desember' ? 'selected' : '' }}>Desember</option>
                    </select>
                </div>

                {{-- Penerima --}}
                <div>
                    <label for="penerima_id" class="block mb-2 text-sm font-medium text-gray-700">Penerima</label>
                    <select id="penerima_id" name="penerima_id" class="select2 block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="" selected>Pilih Penerima</option>
                        @foreach ($pegawais as $pegawai)
                        <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                        @endforeach
                    </select>
                </div>


                {{-- Tombol Submit --}}
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('rincian_belanja_umum.index') }}" class="text-gray-700 hover:text-blue-600">Kembali</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>




</x-app-layout>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pengeluaran = document.getElementById('pengeluaran');
        const pph21 = document.getElementById('pph21_pajak');
        const pph22 = document.getElementById('pph22_pajak');
        const pph23 = document.getElementById('pph23_pajak');
        const ppn = document.getElementById('ppn_pajak');
        const netto = document.getElementById('netto');

        function calculateNetto() {
            const pengeluaranValue = parseFloat(pengeluaran.value) || 0;
            const totalPajak =
                (parseFloat(pph21.value) || 0) +
                (parseFloat(pph22.value) || 0) +
                (parseFloat(pph23.value) || 0) +
                (parseFloat(ppn.value) || 0);

            netto.value = pengeluaranValue - totalPajak;
        }

        // Event listener untuk menghitung netto setiap ada perubahan
        [pengeluaran, pph21, pph22, pph23, ppn].forEach(input => {
            input.addEventListener('input', calculateNetto);
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('#penerima_id').select2({
            placeholder: "Pilih Penerima",
            allowClear: true
        });
    });
</script>