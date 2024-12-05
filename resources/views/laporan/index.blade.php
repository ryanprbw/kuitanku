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
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400 border border-gray-300">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-400 border-b border-gray-300">
                                <tr>
                                    <th class="px-6 py-3 border-r border-gray-300">Program</th>
                                    <th class="px-6 py-3 border-r border-gray-300">Kegiatan</th>
                                    <th class="px-6 py-3 border-r border-gray-300">Sub Kegiatan</th>
                                    <th class="px-6 py-3 border-r border-gray-300">Kode Rekening</th>
                                    <th class="px-6 py-3">Rincian Belanja Umum</th>
                                    <th class="px-6 py-3">Anggaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rincianBelanjaUmum as $key => $rincianGroup)
                                    @foreach ($rincianGroup as $index => $rincian)
                                        @if ($index == 0) <!-- Tampilkan data program, kegiatan, sub kegiatan, kode rekening hanya sekali -->
                                            <tr class="border-t border-gray-300">
                                                <td rowspan="{{ $rincianGroup->count() }}" class="border-r border-gray-300">{{ $rincian->program->nama ?? 'Tidak ada Program' }}</td>
                                                <td rowspan="{{ $rincianGroup->count() }}" class="border-r border-gray-300">{{ $rincian->kegiatan->nama_kegiatan ?? 'Tidak ada Kegiatan' }}</td>
                                                <td rowspan="{{ $rincianGroup->count() }}" class="border-r border-gray-300">{{ $rincian->subKegiatan->nama_sub_kegiatan ?? 'Tidak ada Sub Kegiatan' }}</td>
                                                <td rowspan="{{ $rincianGroup->count() }}" class="border-r border-gray-300">{{ $rincian->kodeRekening->nama_kode_rekening ?? 'Tidak ada Kode Rekening' }}</td>
                                                <td class="border-r border-gray-300">{{ $rincian->untuk_pengeluaran }}</td>
                                                <td class="border-r border-gray-300">{{ $rincian->anggaran }}</td>
                                                
                                            </tr>
                                        @else
                                            <tr class="border-t border-gray-300">
                                                <td class="border-r border-gray-300">{{ $rincian->untuk_pengeluaran }}</td>
                                                <td class="border-r border-gray-300">{{ $rincian->anggaran }}</td>
                                            </tr>
                                        @endif
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
