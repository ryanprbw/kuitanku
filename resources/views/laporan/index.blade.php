<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flowbite Card Component -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Tabel Laporan -->
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-400 border-b border-gray-300">
                                <tr>
                                    <th class="px-6 py-3">Program</th>
                                    <th class="px-6 py-3">Kegiatan</th>
                                    <th class="px-6 py-3">Sub Kegiatan</th>
                                    <th class="px-6 py-3">Kode Rekening</th>
                                    <th class="px-6 py-3">Bidang</th>
                                    <th class="px-6 py-3">Rincian Belanja Umum</th>
                                    <th class="px-6 py-3">Anggaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rincianBelanjaUmum as $rincianGroup)
                                    @foreach ($rincianGroup as $index => $rincian)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            @if ($index == 0)
                                                <td rowspan="{{ $rincianGroup->count() }}" class="p-4 ">{{ $rincian->program->nama ?? 'Tidak ada Program' }}</td>
                                                <td rowspan="{{ $rincianGroup->count() }}" class="p-4">{{ $rincian->kegiatan->nama_kegiatan ?? 'Tidak ada Kegiatan' }}</td>
                                                <td rowspan="{{ $rincianGroup->count() }}" class="p-4">{{ $rincian->subKegiatan->nama_sub_kegiatan ?? 'Tidak ada Sub Kegiatan' }}</td>
                                                <td rowspan="{{ $rincianGroup->count() }}" class="p-4">{{ $rincian->kodeRekening->nama_kode_rekening ?? 'Tidak ada Kode Rekening' }}</td>
                                                <td rowspan="{{ $rincianGroup->count() }}" class="p-4 border-r dark:border-gray-700">{{ $rincian->bidang->nama_bidang ?? 'Tidak ada Bidang' }}</td>
                                                
                                            @endif
                                            <td class="p-4">{{ $rincian->untuk_pengeluaran }}</td>
                                            <td class="p-4">{{ $rincian->anggaran }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
