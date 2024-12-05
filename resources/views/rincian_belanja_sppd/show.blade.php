<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Rincian Belanja Sppd') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Detail Header -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">Informasi Rincian SPPD</h3>
                    </div>
                    <div class="mb-4">
                        <a href="{{ route('rincian_belanja_sppd.pdf.detail', $rincianSppd->id) }}" 
                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Cetak PDF
                        </a>
                    </div>
                    <!-- Detail Table -->
                    <div class="overflow-hidden">
                        <table class="table-auto w-full text-left border-collapse border border-gray-200">
                            <tbody>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Program</td>
                                    <td class="px-4 py-2 border border-gray-200">{{ $rincianSppd->program->nama ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Kegiatan</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        {{ $rincianSppd->kegiatan->nama_kegiatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Sub Kegiatan</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        {{ $rincianSppd->subKegiatan->nama_sub_kegiatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Kode Rekening</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        {{ $rincianSppd->kodeRekening->nama_kode_rekening ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Jumlah (Sebesar)</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        Rp{{ number_format($rincianSppd->sebesar, 0, ',', '.') }}  <br>{{ preg_replace('/([a-z])([A-Z])/', '$1 $2', $rincianSppd->terbilang_rupiah) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Nomor Surat Tugas</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        Nomor {{ $rincianSppd->nomor_st ?? '-' }} pada tanggal  {{ $rincianSppd->tanggal_st ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Nomor Surat Perjalanan Dinas</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        Nomor {{ $rincianSppd->nomor_spd ?? '-' }} pada tanggal  {{ $rincianSppd->tanggal_spd ?? '-' }}</td>
                                </tr>
                              
                             
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">PPTK</td>
                                    <td class="px-4 py-2 border border-gray-200">{{ $rincianSppd->pptk->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Bendahara</td>
                                    <td class="px-4 py-2 border border-gray-200">{{ $rincianSppd->bendahara->nama ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Kepala Dinas</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        {{ $rincianSppd->kepalaDinas->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Penerima</td>
                                    <td class="px-4 py-2 border border-gray-200">{{ $rincianSppd->penerima->nama ?? '-' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Button Back -->
                    <div class="mt-6">
                        <a href="{{ route('rincian_belanja_sppd.index') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
