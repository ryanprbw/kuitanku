<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Rincian Belanja Umum') }}
        </h2>
    </x-slot>

    <div class="container ">
        <div class=" bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-6">Edit Rincian Belanja Umum</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 text-red-800 bg-red-200 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('rincian_belanja_umum.update', $rincianBelanja->id) }}" method="POST"
                class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Program --}}
                <div>
                    <label for="program_id" class="block mb-2 text-sm font-medium text-gray-700">Program</label>
                    <select id="program_id" name="program_id"
                        class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="">Pilih Program</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}"
                                {{ $rincianBelanja->program_id == $program->id ? 'selected' : '' }}>
                                {{ $program->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kegiatan --}}
                <div>
                    <label for="kegiatan_id" class="block mb-2 text-sm font-medium text-gray-700">Kegiatan</label>
                    <select id="kegiatan_id" name="kegiatan_id"
                        class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="">Pilih Kegiatan</option>
                        @foreach ($kegiatans as $kegiatan)
                            <option value="{{ $kegiatan->id }}"
                                {{ $rincianBelanja->kegiatan_id == $kegiatan->id ? 'selected' : '' }}>
                                {{ $kegiatan->nama_kegiatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sub Kegiatan --}}
                <div>
                    <label for="sub_kegiatan_id" class="block mb-2 text-sm font-medium text-gray-700">Sub
                        Kegiatan</label>
                    <select id="sub_kegiatan_id" name="sub_kegiatan_id"
                        class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="">Pilih Sub Kegiatan</option>
                        @foreach ($sub_kegiatans as $sub_kegiatan)
                            <option value="{{ $sub_kegiatan->id }}"
                                {{ $rincianBelanja->sub_kegiatan_id == $sub_kegiatan->id ? 'selected' : '' }}>
                                {{ $sub_kegiatan->nama_sub_kegiatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kode Rekening --}}
                {{-- Kode Rekening --}}
                <div>
                    <label for="kode_rekening_id" class="block mb-2 text-sm font-medium text-gray-700">Kode
                        Rekening</label>
                    <select id="kode_rekening_id" name="kode_rekening_id" class="w-full">
                        <option value="" selected>Pilih Kode Rekening</option>
                        @foreach ($kode_rekenings as $kode_rekening)
                            <option value="{{ $kode_rekening->id }}"
                                data-html="
                                        <strong>{{ $kode_rekening->nama_kode_rekening }}</strong><br>
                                        <span style='color:green;'>Sisa Anggaran: Rp. {{ number_format($kode_rekening->anggaran, 0, ',', '.') }}</span><br>
                                        <span style='color:red;'>Anggaran Awal: Rp. {{ number_format($kode_rekening->anggaran_awal, 0, ',', '.') }}</span><br>
                                        <span style='color:gray;'>Bidang: {{ $kode_rekening->bidang->nama_bidang ?? 'Tidak Ada' }}</span>
                                    ">
                                {{ $kode_rekening->nama_kode_rekening }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Anggaran --}}
                <div>
                    <label for="anggaran" class="block mb-2 text-sm font-medium text-gray-700">Anggaran</label>
                    <input type="number" step="0.01" id="anggaran" name="anggaran"
                        class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200"
                        value="{{ old('anggaran', $rincianBelanja->anggaran) }}">
                </div>

                {{-- Sebesar --}}
                <div>
                    <label for="sebesar" class="block mb-2 text-sm font-medium text-gray-700">Sebesar</label>
                    <input type="number" step="0.01" id="sebesar" name="sebesar"
                        class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200"
                        value="{{ old('sebesar', $rincianBelanja->sebesar) }}">
                </div>

                {{-- Untuk Pengeluaran --}}
                <div>
                    <label for="untuk_pengeluaran" class="block mb-2 text-sm font-medium text-gray-700">Untuk
                        Pengeluaran</label>
                    <textarea id="untuk_pengeluaran" name="untuk_pengeluaran" rows="3"
                        class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">{{ old('untuk_pengeluaran', $rincianBelanja->untuk_pengeluaran) }}</textarea>
                </div>

                {{-- Pajak --}}
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <label for="dpp" class="block mb-2 text-sm font-medium text-gray-700">DPP</label>
                        <input type="number" step="0.01" id="dpp" name="dpp"
                            class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200"
                            value="{{ old('dpp', $rincianBelanja->dpp) }}">
                    </div>
                    <div>
                        <label for="pph21" class="block mb-2 text-sm font-medium text-gray-700">PPH21</label>
                        <input type="number" step="0.01" id="pph21" name="pph21"
                            class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200"
                            value="{{ old('pph21', $rincianBelanja->pph21) }}">
                    </div>
                    <div>
                        <label for="pph22" class="block mb-2 text-sm font-medium text-gray-700">PPH22</label>
                        <input type="number" step="0.01" id="pph22" name="pph22"
                            class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200"
                            value="{{ old('pph22', $rincianBelanja->pph22) }}">
                    </div>
                    <div>
                        <label for="pph23" class="block mb-2 text-sm font-medium text-gray-700">PPH23</label>
                        <input type="number" step="0.01" id="pph23" name="pph23"
                            class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200"
                            value="{{ old('pph23', $rincianBelanja->pph23) }}">
                    </div>
                    <div>
                        <label for="ppn" class="block mb-2 text-sm font-medium text-gray-700">PPN</label>
                        <input type="number" step="0.01" id="ppn" name="ppn"
                            class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200"
                            value="{{ old('pph23', $rincianBelanja->ppn) }}">
                    </div>
                </div>
                {{-- Kepala Dinas --}}
                <div>
                    <label for="kepala_dinas_id" class="block mb-2 text-sm font-medium text-gray-700">Kepala
                        Dinas</label>
                    <select id="kepala_dinas_id" name="kepala_dinas_id"
                        class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="">Pilih Kepala Dinas</option>
                        @foreach ($kepala_dinas as $dinas)
                            <option value="{{ $dinas->id }}"
                                {{ old('kepala_dinas_id', $rincianBelanja->kepala_dinas_id) == $dinas->id ? 'selected' : '' }}>
                                {{ $dinas->nama }}
                            </option>
                        @endforeach
                    </select>

                </div>

                {{-- PPTK --}}
                <div>
                    <label for="pptk_id" class="block mb-2 text-sm font-medium text-gray-700">PPTK</label>
                    <select id="pptk_id" name="pptk_id"
                        class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="">Pilih PPTK</option>
                        @foreach ($pptks as $pptk)
                            <option value="{{ $pptk->id }}"
                                {{ old('pptk_id', $rincianBelanja->pptk_id) == $pptk->id ? 'selected' : '' }}>
                                {{ $pptk->nama }}
                            </option>
                        @endforeach
                    </select>

                </div>

                {{-- Bendahara --}}
                <div>
                    <label for="bendahara_id" class="block mb-2 text-sm font-medium text-gray-700">Bendahara</label>
                    <select id="bendahara_id" name="bendahara_id"
                        class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="">Pilih Bendahara</option>
                        @foreach ($bendaharas as $bendahara)
                            <option value="{{ $bendahara->id }}"
                                {{ old('bendahara_id', $rincianBelanja->bendahara_id) == $bendahara->id ? 'selected' : '' }}>
                                {{ $bendahara->nama }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div>
                    <label for="bulan" class="block mb-2 text-sm font-medium text-gray-700">Diterima pada
                        Bulan</label>
                    <select id="bulan" name="bulan"
                        class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="" disabled selected>Pilih Bulan</option>
                        <option value="Januari"
                            {{ old('bulan', $rincianBelanja->bulan ?? '') == 'Januari' ? 'selected' : '' }}>Januari
                        </option>
                        <option value="Februari"
                            {{ old('bulan', $rincianBelanja->bulan ?? '') == 'Februari' ? 'selected' : '' }}>Februari
                        </option>
                        <option value="Maret"
                            {{ old('bulan', $rincianBelanja->bulan ?? '') == 'Maret' ? 'selected' : '' }}>Maret
                        </option>
                        <option value="April"
                            {{ old('bulan', $rincianBelanja->bulan ?? '') == 'April' ? 'selected' : '' }}>April
                        </option>
                        <option value="Mei"
                            {{ old('bulan', $rincianBelanja->bulan ?? '') == 'Mei' ? 'selected' : '' }}>Mei</option>
                        <option value="Juni"
                            {{ old('bulan', $rincianBelanja->bulan ?? '') == 'Juni' ? 'selected' : '' }}>Juni</option>
                        <option value="Juli"
                            {{ old('bulan', $rincianBelanja->bulan ?? '') == 'Juli' ? 'selected' : '' }}>Juli</option>
                        <option value="Agustus"
                            {{ old('bulan', $rincianBelanja->bulan ?? '') == 'Agustus' ? 'selected' : '' }}>Agustus
                        </option>
                        <option value="September"
                            {{ old('bulan', $rincianBelanja->bulan ?? '') == 'September' ? 'selected' : '' }}>September
                        </option>
                        <option value="Oktober"
                            {{ old('bulan', $rincianBelanja->bulan ?? '') == 'Oktober' ? 'selected' : '' }}>Oktober
                        </option>
                        <option value="November"
                            {{ old('bulan', $rincianBelanja->bulan ?? '') == 'November' ? 'selected' : '' }}>November
                        </option>
                        <option value="Desember"
                            {{ old('bulan', $rincianBelanja->bulan ?? '') == 'Desember' ? 'selected' : '' }}>Desember
                        </option>
                        <option class="text-red-600 bold animate-pulse" value=""
                            {{ old('bulan', isset($rincianBelanja) ? $rincianBelanja->bulan : '') == '' ? 'selected' : '' }}>
                            Kosongkan Bulan</option>

                    </select>
                </div>


                {{-- Penerima --}}
                <div>
                    <label for="penerima_id" class="block mb-2 text-sm font-medium text-gray-700">Penerima</label>
                    <select id="penerima_id" name="penerima_id"
                        class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="">Pilih Penerima</option>
                        @foreach ($pegawais as $pegawai)
                            <option value="{{ $pegawai->id }}"
                                {{ old('penerima_id', $rincianBelanja->penerima_id) == $pegawai->id ? 'selected' : '' }}>
                                {{ $pegawai->nama }}
                            </option>
                        @endforeach
                    </select>

                </div>


                {{-- Tombol Submit --}}
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('rincian_belanja_umum.index') }}"
                        class="text-gray-700 hover:text-blue-600">Kembali</a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function() {
        // Mengaktifkan Select2 pada elemen select dengan id "kode_rekening_id"
        $('#kode_rekening_id').select2({
            placeholder: "Pilih Kode Rekening", // Placeholder saat dropdown kosong
            allowClear: true // Menambahkan opsi untuk menghapus pilihan
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#kode_rekening_id').select2({
            templateResult: function(data) {
                if (!data.id) return data.text;
                const html = $(data.element).data('html');
                return $(html);
            },
            templateSelection: function(data) {
                return data.text; // hanya teks yang ditampilkan saat dipilih
            }
        });
    });
</script>
