<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Rincian Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('rincian_belanja_v2.update', $rincianBelanja->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Program -->
                            <div>
                                <label for="program_id" class="block text-sm font-medium text-gray-700">{{ __('Program') }}</label>
                                <select name="program_id" id="program_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                                    <option value="" disabled selected>{{ __('Pilih Program') }}</option>
                                    @foreach ($programs as $program)
                                        <option value="{{ $program->id }}" {{ $rincianBelanja->program_id == $program->id ? 'selected' : '' }}>
                                            {{ $program->nama }}</option>
                                    @endforeach
                                </select>
                                @error('program_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Kegiatan -->
                            <div>
                                <label for="kegiatan_id" class="block text-sm font-medium text-gray-700">{{ __('Kegiatan') }}</label>
                                <select name="kegiatan_id" id="kegiatan_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                                    <option value="" disabled selected>{{ __('Pilih Kegiatan') }}</option>
                                    @foreach ($kegiatans as $kegiatan)
                                        <option value="{{ $kegiatan->id }}" {{ $rincianBelanja->kegiatan_id == $kegiatan->id ? 'selected' : '' }}>
                                            {{ $kegiatan->nama_kegiatan }}</option>
                                    @endforeach
                                </select>
                                @error('kegiatan_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Sub Kegiatan -->
                            <div>
                                <label for="sub_kegiatan_id" class="block text-sm font-medium text-gray-700">{{ __('Sub Kegiatan') }}</label>
                                <select name="sub_kegiatan_id" id="sub_kegiatan_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                                    <option value="" disabled selected>{{ __('Pilih Sub Kegiatan') }}</option>
                                    @foreach ($subKegiatans as $sub)
                                        <option value="{{ $sub->id }}" {{ $rincianBelanja->sub_kegiatan_id == $sub->id ? 'selected' : '' }}>
                                            {{ $sub->nama_sub_kegiatans }}</option>
                                    @endforeach
                                </select>
                                @error('sub_kegiatan_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Kode Rekening -->
                            <div>
                                <label for="kode_rekening_id" class="block text-sm font-medium text-gray-700">{{ __('Kode Rekening') }}</label>
                                <select name="kode_rekening_id" id="kode_rekening_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                                    <option value="" disabled selected>{{ __('Pilih Kode Rekening') }}</option>
                                    @foreach ($kodeRekenings as $kodeRekening)
                                        <option value="{{ $kodeRekening->id }}" {{ $rincianBelanja->kode_rekening_id == $kodeRekening->id ? 'selected' : '' }}>
                                            {{ $kodeRekening->nama_kode_rekening }} </option>
                                    @endforeach
                                </select>
                                @error('kode_rekening_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Anggaran -->
                            <div>
                                <label for="anggaran" class="block text-sm font-medium text-gray-700">{{ __('Anggaran') }}</label>
                                <input type="number" name="anggaran" id="anggaran"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    value="{{ old('anggaran', $rincianBelanja->anggaran) }}" required oninput="updateTerbilang()">
                                @error('anggaran')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Terbilang -->
                            <div class="col-span-2">
                                <label for="terbilang" class="block text-sm font-medium text-gray-700">{{ __('Terbilang') }}</label>
                                <input type="text" name="terbilang" id="terbilang"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    value="{{ old('terbilang', $rincianBelanja->terbilang) }}" readonly>
                                @error('terbilang')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Untuk Pengeluaran -->
                            <div class="col-span-2">
                                <label for="untuk_pengeluaran"
                                    class="block text-sm font-medium text-gray-700">{{ __('Untuk Pengeluaran') }}</label>
                                <input type="text" name="untuk_pengeluaran" id="untuk_pengeluaran"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    value="{{ old('untuk_pengeluaran', $rincianBelanja->untuk_pengeluaran) }}" required>
                                @error('untuk_pengeluaran')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nomor ST -->
                            <div>
                                <label for="nomor_st"
                                    class="block text-sm font-medium text-gray-700">{{ __('Nomor ST') }}</label>
                                <input type="text" name="nomor_st" id="nomor_st"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    value="{{ old('nomor_st', $rincianBelanja->nomor_st) }}" required>
                                @error('nomor_st')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tanggal ST -->
                            <div>
                                <label for="tanggal_st"
                                    class="block text-sm font-medium text-gray-700">{{ __('Tanggal ST') }}</label>
                                <input type="date" name="tanggal_st" id="tanggal_st"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    value="{{ old('tanggal_st', $rincianBelanja->tanggal_st) }}" required>
                                @error('tanggal_st')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nomor SPD -->
                            <div>
                                <label for="nomor_spd"
                                    class="block text-sm font-medium text-gray-700">{{ __('Nomor SPD') }}</label>
                                <input type="text" name="nomor_spd" id="nomor_spd"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    value="{{ old('nomor_spd', $rincianBelanja->nomor_spd) }}" required>
                                @error('nomor_spd')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tanggal SPD -->
                            <div>
                                <label for="tanggal_spd"
                                    class="block text-sm font-medium text-gray-700">{{ __('Tanggal SPD') }}</label>
                                <input type="date" name="tanggal_spd" id="tanggal_spd"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    value="{{ old('tanggal_spd', $rincianBelanja->tanggal_spd) }}" required>
                                @error('tanggal_spd')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Kepala Dinas -->
                            <div>
                                <label for="kepala_dinas_id" class="block text-sm font-medium text-gray-700">{{ __('Kepala Dinas') }}</label>
                                <select name="kepala_dinas_id" id="kepala_dinas_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                                    <option value="" disabled selected>{{ __('Pilih Kepala Dinas') }}</option>
                                    @foreach ($kepalaDinas as $kd)
                                        <option value="{{ $kd->id }}" {{ $rincianBelanja->kepala_dinas_id == $kd->id ? 'selected' : '' }}>
                                            {{ $kd->nama }}</option>
                                    @endforeach
                                </select>
                                @error('kepala_dinas_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- PPTK -->
                            <div>
                                <label for="pptk_id" class="block text-sm font-medium text-gray-700">{{ __('PPTK') }}</label>
                                <select name="pptk_id" id="pptk_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                                    <option value="" disabled selected>{{ __('Pilih PPTK') }}</option>
                                    @foreach ($pptks as $pptk)
                                        <option value="{{ $pptk->id }}" {{ $rincianBelanja->pptk_id == $pptk->id ? 'selected' : '' }}>
                                            {{ $pptk->nama }}</option>
                                    @endforeach
                                </select>
                                @error('pptk_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Bendahara -->
                            <div>
                                <label for="bendahara_id" class="block text-sm font-medium text-gray-700">{{ __('Bendahara') }}</label>
                                <select name="bendahara_id" id="bendahara_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                                    <option value="" disabled selected>{{ __('Pilih Bendahara') }}</option>
                                    @foreach ($bendaharas as $bd)
                                        <option value="{{ $bd->id }}" {{ $rincianBelanja->bendahara_id == $bd->id ? 'selected' : '' }}>
                                            {{ $bd->nama }}</option>
                                    @endforeach
                                </select>
                                @error('bendahara_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Pegawai -->
                            <div>
                                <label for="pegawai_id" class="block text-sm font-medium text-gray-700">{{ __('Pegawai') }}</label>
                                <select name="pegawai_id" id="pegawai_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                                    <option value="" disabled selected>{{ __('Pilih Pegawai') }}</option>
                                    @foreach ($pegawais as $p)
                                        <option value="{{ $p->id }}" {{ $rincianBelanja->pegawai_id == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama }}</option>
                                    @endforeach
                                </select>
                                @error('pegawai_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="col-span-2 text-right">
                                <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">
                                    {{ __('Simpan Perubahan') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
