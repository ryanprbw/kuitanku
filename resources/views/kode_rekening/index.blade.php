<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kode Rekening') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Kode Rekening</h3>
                        {{-- <h3 class="text-lg font-semibold">Sisa Anggaran: Rp
                            {{ number_format($totalAnggaran, 0, ',', '.') }}</h3> --}}
                        <a href="{{ route('kode_rekening.create') }}"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Tambah Kode Rekening
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-gray-700">Nama Kode Rekening</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Sub Kegiatan</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Bidang</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Anggaran Awal</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Anggaran Realisasi</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Sisa Anggaran</th>
                                    <th class="px-4 py-2 text-center text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($kodeRekenings as $kodeRekening)
                                    <tr>
                                        <td class="px-4 py-2">{{ $kodeRekening->nama_kode_rekening }}</td>
                                        <td class="px-4 py-2">{{ $kodeRekening->subKegiatan->nama_sub_kegiatan ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2">{{ $kodeRekening->bidang->nama_bidang ?? '-' }}</td>
                                        <td class="px-4 py-2">Rp
                                            {{ number_format($kodeRekening->anggaran_awal, 2, ',', '.') }}</td>
                                        <td class="px-4 py-2">Rp
                                            {{ number_format($kodeRekening->anggaran_realisasi, 2, ',', '.') }}</td>
                                        <td class="px-4 py-2">Rp
                                            {{ number_format($kodeRekening->anggaran, 2, ',', '.') }}</td>
                                        <td class="px-4 py-2 text-center">
                                            @if (Auth::user()->role !== 'bidang')
                                                <a href="{{ route('kode_rekening.show', $kodeRekening->id) }}"
                                                    class="text-green-500 hover:underline">Detail</a>
                                                <a href="{{ route('kode_rekening.edit', $kodeRekening->id) }}"
                                                    class="text-blue-500 hover:underline ml-2">Edit</a>
                                                <form action="{{ route('kode_rekening.destroy', $kodeRekening->id) }}"
                                                    method="POST" class="inline ml-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:underline"
                                                        onclick="return confirm('Yakin ingin menghapus kode rekening ini?')">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-2 text-center text-gray-500">Tidak ada kode
                                            rekening yang terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $kodeRekenings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
