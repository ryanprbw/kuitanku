<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Rincian Belanja Umum') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Detail Header -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">Informasi Rincian</h3>
                    </div>
                    <div class="mb-4">
                        <a href="{{ route('rincian_belanja_umum.pdf.detail', $rincian->id) }}" 
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
                                    <td class="px-4 py-2 border border-gray-200">{{ $rincian->program->nama ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Kegiatan</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        {{ $rincian->kegiatan->nama_kegiatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Sub Kegiatan</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        {{ $rincian->subKegiatan->nama_sub_kegiatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Kode Rekening</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        {{ $rincian->kodeRekening->nama_kode_rekening ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Jumlah (Bruto)</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        Rp{{ number_format($rincian->bruto, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Total Pajak</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        Rp{{ number_format($rincian->total_pajak, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Jumlah (Netto)</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        Rp{{ number_format($rincian->netto, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Terbilang</td>
                                    <td class="px-4 py-2 border border-gray-200 italic">{{ $rincian->terbilang_rupiah }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">PPTK</td>
                                    <td class="px-4 py-2 border border-gray-200">{{ $rincian->pptk->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Bendahara</td>
                                    <td class="px-4 py-2 border border-gray-200">{{ $rincian->bendahara->nama ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Kepala Dinas</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        {{ $rincian->kepalaDinas->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold border border-gray-200">Penerima</td>
                                    <td class="px-4 py-2 border border-gray-200">{{ $rincian->penerima->nama ?? '-' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Button Back -->
                    <div class="mt-6">
                        <a href="{{ route('rincian_belanja_umum.index') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
