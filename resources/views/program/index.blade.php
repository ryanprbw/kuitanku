<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Program') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Total Program: {{ $programs->count() }}</h3>
                        <h3 class="text-lg font-semibold">Sisa Anggaran: Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</h3>
                        <a href="{{ route('program.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Tambah Program
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-gray-700">Nama Program</th>
                                    <th class="px-4 py-2 text-left text-gray-700">SKPD</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Bidang</th>
                                    <th class="px-4 py-2 text-left text-gray-700">Anggaran</th>
                                    <th class="px-4 py-2 text-center text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($programs as $program)
                                <tr>
                                    <td class="px-4 py-2">{{ $program->nama }}</td>
                                    <td class="px-4 py-2">{{ $program->skpd->nama_skpd }}</td>
                                    <td class="px-4 py-2">{{ $program->bidang->nama_bidang }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($program->anggaran, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="{{ route('program.show', $program->id) }}" class="text-green-500 hover:underline">Show</a>
                                        @if(Auth::user()->role !== 'bidang')
                                        <a href="{{ route('program.edit', $program->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('program.destroy', $program->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                        </form>
                                        @endif
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 text-center text-gray-500">Belum ada program yang terdaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $programs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>