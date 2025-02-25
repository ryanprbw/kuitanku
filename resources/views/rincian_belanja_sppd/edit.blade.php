<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Rincian Belanja SPPD') }}
        </h2>
    </x-slot>

    <div class="container ">
        <div class=" bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-6">Edit Rincian Belanja SPPD</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 text-red-800 bg-red-200 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('rincian_belanja_sppd.update', $rincianSppd->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Program --}}
                <div>
                    <label for="program_id" class="block mb-2 text-sm font-medium text-gray-700">Program</label>
                    <select id="program_id" name="program_id" class="block w-full px-3 py-2 border rounded-lg">
                        <option value="">Pilih Program</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}"
                                {{ $rincianSppd->program_id == $program->id ? 'selected' : '' }}>
                                {{ $program->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kegiatan --}}
                <div>
                    <label for="kegiatan_id" class="block mb-2 text-sm font-medium text-gray-700">Kegiatan</label>
                    <select id="kegiatan_id" name="kegiatan_id" class="block w-full px-3 py-2 border rounded-lg">
                        <option value="">Pilih Kegiatan</option>
                        @foreach ($kegiatans as $kegiatan)
                            <option value="{{ $kegiatan->id }}"
                                {{ $rincianSppd->kegiatan_id == $kegiatan->id ? 'selected' : '' }}>
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
                        class="block w-full px-3 py-2 border rounded-lg">
                        <option value="">Pilih Sub Kegiatan</option>
                        @foreach ($sub_kegiatans as $sub_kegiatan)
                            <option value="{{ $sub_kegiatan->id }}"
                                {{ $rincianSppd->sub_kegiatan_id == $sub_kegiatan->id ? 'selected' : '' }}>
                                {{ $sub_kegiatan->nama_sub_kegiatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kode Rekening --}}
                <div>
                    <label for="kode_rekening_id" class="block mb-2 text-sm font-medium text-gray-700">Kode
                        Rekening</label>
                    <select id="kode_rekening_id" name="kode_rekening_id"
                        class="block w-full px-3 py-2 border rounded-lg">
                        <option value="">Pilih Kode Rekening</option>
                        @foreach ($kode_rekenings as $kode_rekening)
                            <option value="{{ $kode_rekening->id }}"
                                {{ $rincianSppd->kode_rekening_id == $kode_rekening->id ? 'selected' : '' }}>
                                {{ $kode_rekening->nama_kode_rekening }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sebesar --}}
                <div>
                    <label for="anggaran" class="block mb-2 text-sm font-medium text-gray-700">Anggaran (Rp)</label>
                    <input type="number" step="0.01" id="anggaran" name="anggaran"
                        class="block w-full px-3 py-2 border rounded-lg"
                        value="{{ old('anggaran', $rincianSppd->anggaran) }}">
                </div>
                <div>
                    <label for="sebesar" class="block mb-2 text-sm font-medium text-gray-700">Sebesar (Rp)</label>
                    <input type="number" step="0.01" id="sebesar" name="sebesar"
                        class="block w-full px-3 py-2 border rounded-lg"
                        value="{{ old('sebesar', $rincianSppd->sebesar) }}">
                </div>

                {{-- Untuk Pengeluaran --}}
                <div>
                    <label for="untuk_pengeluaran" class="block mb-2 text-sm font-medium text-gray-700">Untuk
                        Pengeluaran</label>
                    <textarea id="untuk_pengeluaran" name="untuk_pengeluaran" rows="3"
                        class="block w-full px-3 py-2 border rounded-lg">{{ old('untuk_pengeluaran', $rincianSppd->untuk_pengeluaran) }}</textarea>
                </div>

                {{-- Nomor ST & Tanggal ST --}}
                <div>
                    <label for="nomor_spd" class="block mb-2 text-sm font-medium text-gray-700">Nomor SPD</label>
                    <input type="text" id="nomor_spd" name="nomor_spd"
                        class="block w-full px-3 py-2 border rounded-lg"
                        value="{{ old('nomor_spd', $rincianSppd->nomor_spd) }}">
                </div>
                <div>
                    <label for="tanggal_spd" class="block mb-2 text-sm font-medium text-gray-700">Tanggal SPD</label>
                    <input type="date" id="tanggal_spd" name="tanggal_spd"
                        class="block w-full px-3 py-2 border rounded-lg"
                        value="{{ old('tanggal_spd', $rincianSppd->tanggal_spd) }}">
                </div>
                {{-- Nomor ST & Tanggal ST --}}
                <div>
                    <label for="nomor_st" class="block mb-2 text-sm font-medium text-gray-700">Nomor ST</label>
                    <input type="text" id="nomor_st" name="nomor_st"
                        class="block w-full px-3 py-2 border rounded-lg"
                        value="{{ old('nomor_st', $rincianSppd->nomor_st) }}">
                </div>
                <div>
                    <label for="tanggal_st" class="block mb-2 text-sm font-medium text-gray-700">Tanggal ST</label>
                    <input type="date" id="tanggal_st" name="tanggal_st"
                        class="block w-full px-3 py-2 border rounded-lg"
                        value="{{ old('tanggal_st', $rincianSppd->tanggal_st) }}">
                </div>

                {{-- Kepala Dinas --}}
                <div>
                    <label for="kepala_dinas_id" class="block mb-2 text-sm font-medium text-gray-700">Kepala
                        Dinas</label>
                    <select id="kepala_dinas_id" name="kepala_dinas_id"
                        class="block w-full px-3 py-2 border rounded-lg">
                        <option value="">Pilih Kepala Dinas</option>
                        @foreach ($kepala_dinas as $dinas)
                            <option value="{{ $dinas->id }}"
                                {{ old('kepala_dinas_id', $rincianSppd->kepala_dinas_id) == $dinas->id ? 'selected' : '' }}>
                                {{ $dinas->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- PPTK --}}
                <div>
                    <label for="pptk_id" class="block mb-2 text-sm font-medium text-gray-700">PPTK</label>
                    <select id="pptk_id" name="pptk_id" class="block w-full px-3 py-2 border rounded-lg">
                        <option value="">Pilih PPTK</option>
                        @foreach ($pptks as $pptk)
                            <option value="{{ $pptk->id }}"
                                {{ old('pptk_id', $rincianSppd->pptk_id) == $pptk->id ? 'selected' : '' }}>
                                {{ $pptk->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="bendahara_id" class="block mb-2 text-sm font-medium text-gray-700">Bendahara</label>
                    <select id="bendahara_id" name="bendahara_id"
                        class="block w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-blue-200">
                        <option value="">Pilih Bendahara</option>
                        @foreach ($bendaharas as $bendahara)
                            <option value="{{ $bendahara->id }}"
                                {{ old('bendahara_id', $rincianSppd->bendahara_id) == $bendahara->id ? 'selected' : '' }}>
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
                        <option class="text-red-600 bold animate-pulse font-bold" value=""
                            {{ old('bulan', isset($rincianBelanja) ? $rincianBelanja->bulan : '') == '' ? 'selected' : '' }}>
                            Kosongkan Bulan</option>

                    </select>
                </div>

                {{-- Penerima --}}
                <div>
                    <label for="penerima_id" class="block mb-2 text-sm font-medium text-gray-700">Penerima</label>
                    <select id="penerima_id" name="penerima_id" class="block w-full px-3 py-2 border rounded-lg">
                        <option value="">Pilih Penerima</option>
                        @foreach ($pegawais as $pegawai)
                            <option value="{{ $pegawai->id }}"
                                {{ old('penerima_id', $rincianSppd->penerima_id) == $pegawai->id ? 'selected' : '' }}>
                                {{ $pegawai->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol Submit --}}
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('rincian_belanja_sppd.index') }}"
                        class="text-gray-700 hover:text-blue-600">Kembali</a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
