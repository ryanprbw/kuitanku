<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" action="{{ route('laporan.index') }}" class="mb-4">
                        <div class="flex space-x-4">
                            <div>
                                <label for="bidang" class="block text-sm font-medium text-gray-700">Bidang</label>
                                <select name="bidang" id="bidang" class="mt-1 block w-full p-2 border rounded-md">
                                    <option value="">Semua Bidang</option>
                                    @foreach ($bidangOptions as $bidang)
                                        <option value="{{ $bidang->id }}"
                                            {{ request('bidang') == $bidang->id ? 'selected' : '' }}>
                                            {{ $bidang->nama_bidang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal
                                    Mulai</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="mt-1 block w-full p-2 border rounded-md" value="{{ request('start_date') }}"
                                    max="{{ date('Y-m-d') }}">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal
                                    Selesai</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="mt-1 block w-full p-2 border rounded-md" value="{{ request('end_date') }}"
                                    min="{{ request('start_date') }}">
                            </div>

                            <div>
                                <button type="submit"
                                    class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <form action="{{ route('laporan.cetak') }}" method="GET" class="mt-4">
                        <input type="hidden" name="bidang" value="{{ request('bidang') }}">
                        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                        <input type="hidden" name="end_date" value="{{ request('end_date') }}">

                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                            Cetak Laporan
                        </button>
                    </form>

                    <h3 class="text-lg font-medium text-gray-900">Total Kuitansi yang telah dibuat:
                        {{ $rincianBelanja->count() }}</h3>
                    <h3 class="text-lg font-semibold">Total Belanja yang digunakan: Rp
                        {{ number_format($totalAnggaran, 0, ',', '.') }}</h3>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 border-collapse">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-300">
                                <tr>
                                    <th class="px-4 py-2 bg-gray-200 ">No.</th>
                                    <th class="px-6 py-3 bg-gray-200">Program</th>
                                    <th class="px-6 py-3 bg-gray-200">Kegiatan</th>
                                    <th class="px-6 py-3 bg-gray-200">Sub Kegiatan</th>
                                    <th class="px-6 py-3 bg-gray-200">Kode Rekening</th>
                                    <th class="px-6 py-3 bg-gray-200">Bidang</th>
                                    <th class="px-6 py-3 bg-gray-200">Rincian Belanja Umum</th>
                                    <th class="px-6 py-3 bg-gray-200">Anggaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($rincianBelanja as $programId => $rincianGroup)
                                    @foreach ($rincianGroup as $index => $rincian)
                                        <tr class="bg-white border-b ">
                                            <td class="px-4 py-2 border-r border-gray-200">{{ $no++ }}</td>
                                            @if ($index == 0)
                                                <td rowspan="{{ $rincianGroup->count() }}" class="p-4">
                                                    {{ optional($rincian->program)->nama ?? 'Tidak ada Program' }}
                                                </td>
                                                <td rowspan="{{ $rincianGroup->count() }}" class="p-4">
                                                    {{ optional($rincian->kegiatan)->nama_kegiatan ?? 'Tidak ada Kegiatan' }}
                                                </td>
                                                <td rowspan="{{ $rincianGroup->count() }}" class="p-4">
                                                    {{ optional($rincian->subKegiatan)->nama_sub_kegiatan ?? 'Tidak ada Sub Kegiatan' }}
                                                </td>
                                                <td rowspan="{{ $rincianGroup->count() }}" class="p-4">
                                                    {{ optional($rincian->kodeRekening)->nama_kode_rekening ?? 'Tidak ada Kode Rekening' }}
                                                </td>
                                                <td rowspan="{{ $rincianGroup->count() }}" class="p-4">
                                                    {{ optional($rincian->bidang)->nama_bidang ?? 'Tidak ada Bidang' }}
                                                </td>
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

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
