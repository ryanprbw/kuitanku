<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flowbite Card Component -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('laporan.index') }}" class="mb-4">
                        <div class="flex space-x-4">
                            <!-- Filter Per Bidang -->
                            <div>
                                <label for="bidang" class="block text-sm font-medium text-gray-700">Bidang</label>
                                <select name="bidang" id="bidang" class="mt-1 block w-full p-2 border rounded-md">
                                    <option value="">Semua Bidang</option>
                                    <!-- Loop bidang options -->
                                    @foreach ($bidangOptions as $bidang)
                                        <option value="{{ $bidang->id }}"
                                            {{ request('bidang') == $bidang->id ? 'selected' : '' }}>
                                            {{ $bidang->nama_bidang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Per Rentang Bulan -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal
                                    Mulai</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="mt-1 block w-full p-2 border rounded-md" value="{{ request('start_date') }}">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal
                                    Selesai</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="mt-1 block w-full p-2 border rounded-md" value="{{ request('end_date') }}">
                            </div>


                            <!-- Submit Filter -->
                            <div>
                                <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabel Laporan -->
                    <h3 class="text-lg font-medium text-gray-900">Total Kuitansi yang telah dibuat :
                        {{ $rincianBelanja->count() }}</h3>
                    <h3 class="text-lg font-semibold">Total Belanja yang digunakan : Rp
                        {{ number_format($totalAnggaran, 0, ',', '.') }}</h3>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-400 border-b border-gray-300">
                                <tr>
                                    <th class="px-4 py-2 text-left text-gray-700">No.</th>
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
                                @php $counter = 1; @endphp
                                @foreach ($rincianBelanja as $rincianGroup)
                                    @foreach ($rincianGroup as $index => $rincian)
                                        <tr
                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <td class="px-4 py-2">{{ $counter++ }}</td>
                                            @if ($index == 0)
                                                <td rowspan="{{ $rincianGroup->count() }}" class="p-4">
                                                    {{ $rincian->program->nama ?? 'Tidak ada Program' }}</td>
                                                <td rowspan="{{ $rincianGroup->count() }}" class="p-4">
                                                    {{ $rincian->kegiatan->nama_kegiatan ?? 'Tidak ada Kegiatan' }}
                                                </td>
                                                <td rowspan="{{ $rincianGroup->count() }}" class="p-4">
                                                    {{ $rincian->subKegiatan->nama_sub_kegiatan ?? 'Tidak ada Sub Kegiatan' }}
                                                </td>
                                                <td rowspan="{{ $rincianGroup->count() }}" class="p-4">
                                                    {{ $rincian->kodeRekening->nama_kode_rekening ?? 'Tidak ada Kode Rekening' }}
                                                </td>
                                                <td rowspan="{{ $rincianGroup->count() }} "
                                                    class="p-4 border-r dark:border-gray-700">
                                                    {{ $rincian->bidang->nama_bidang ?? 'Tidak ada Bidang' }}</td>
                                            @endif
                                            <td class="p-4">{{ $rincian->untuk_pengeluaran }}</td>
                                            <td class="p-4">Rp. {{ number_format($rincian->anggaran, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tombol Cetak -->
                    {{-- <form action="{{ route('laporan.cetak') }}" method="GET" class="mt-4">
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md">
                            Cetak Laporan
                        </button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
