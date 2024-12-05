<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar SKPD') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Flash Message -->
                    @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">SKPD</h3>
                        <h3 class="text-lg font-semibold">Sisa Anggaran: Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</h3>
                        <a href="{{ route('skpd.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Tambah SKPD
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-gray-700">Nama SKPD</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Anggaran</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Dibuat pada tanggal</th>
                                    <th class="px-4 py-2 text-center text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($skpds as $skpd)
                                <tr>
                                    <td class="px-4 py-2">{{ $skpd->nama_skpd }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($skpd->anggaran, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">{{ $skpd->created_at }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <!-- Tombol Show -->
                                        <a href="{{ route('skpd.show', $skpd->id) }}" class="text-green-500 hover:underline">Show</a>

                                        <!-- Tombol Edit -->
                                        <a href="{{ route('skpd.edit', $skpd->id) }}" class="text-blue-500 hover:underline ml-2">Edit</a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('skpd.destroy', $skpd->id) }}" method="POST" class="inline ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin menghapus SKPD ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-2 text-center text-gray-500">Belum ada SKPD yang terdaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $skpds->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>