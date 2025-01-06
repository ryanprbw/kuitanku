<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Sub Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('message'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                            {{ session('message.content') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Total Sub-Kegiatan: {{ $subKegiatans->count() }}</h3>
                        <a href="{{ route('sub_kegiatan.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Tambah Sub Kegiatan
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-gray-700">Nama Sub Kegiatan</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Kegiatan</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Bidang</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Anggaran</th>
                                    <th class="px-4 py-2 text-center text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($subKegiatans as $subKegiatan)
                                    <tr>
                                        <td class="px-4 py-2">{{ $subKegiatan->nama_sub_kegiatan }}</td>
                                        <td class="px-4 py-2">{{ $subKegiatan->kegiatan->nama_kegiatan ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $subKegiatan->bidang->nama_bidang ?? '-' }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($subKegiatan->anggaran, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 text-center">
                                            @if(Auth::user()->role !== 'bidang')
                                            <a href="{{ route('sub_kegiatan.edit', $subKegiatan->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                            <form action="{{ route('sub_kegiatan.destroy', $subKegiatan->id) }}" method="POST" class="inline ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin menghapus sub kegiatan ini?')">Hapus</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">Tidak ada sub kegiatan yang terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $subKegiatans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
