<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Rincian Belanja Umum') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Flash Messages -->
                    @if (session('message'))
                        <div class="mb-4 alert alert-{{ session('message.type') }}">
                            {{ session('message.content') }}
                        </div>
                    @endif

                    <!-- Action Button -->
                    <div class="mb-4 flex justify-end">
                        <a href="{{ route('rincian_belanja.create') }}"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Rincian Belanja
                        </a>
                    </div>

                    <!-- Data Table -->
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2 text-left">#</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Kode Rekening</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Program</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Pengeluaran</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rincianBelanja as $item)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $item->kodeRekening?->nama_kode_rekening ?? 'Tidak ada' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $item->program }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ number_format($item->pengeluaran, 2) }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <a href="{{ route('rincian_belanja.show', $item->id) }}"
                                           class="text-green-500 hover:text-green-700 font-medium">
                                            Lihat
                                        </a>
                                        <a href="{{ route('rincian_belanja.edit', $item->id) }}"
                                           class="text-blue-500 hover:text-blue-700 font-medium">
                                            Edit
                                        </a>
                                        <form action="{{ route('rincian_belanja.destroy', $item->id) }}" method="POST"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin ingin menghapus?')"
                                                    class="text-red-500 hover:text-red-700 font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border border-gray-300 px-4 py-2 text-center">
                                        Tidak ada data rincian belanja umum.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $rincianBelanja->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
