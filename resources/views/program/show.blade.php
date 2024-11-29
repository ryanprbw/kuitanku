<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Program') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $program->nama }}</h3>

                    <div class="space-y-4">
                        <div>
                            <h4 class="font-medium text-gray-700">SKPD:</h4>
                            <p class="text-gray-800">{{ $program->skpd->nama_skpd ?? '-' }}</p>
                        </div>

                        <div>
                            <h4 class="font-medium text-gray-700">Bidang:</h4>
                            <p class="text-gray-800">{{ $program->bidang->nama_bidang ?? '-' }}</p>
                        </div>

                        <div>
                            <h4 class="font-medium text-gray-700">Anggaran:</h4>
                            <p class="text-gray-800">Rp {{ number_format($program->anggaran, 0, ',', '.') }}</p>
                        </div>

                        <div>
                            <h4 class="font-medium text-gray-700">Dibuat pada:</h4>
                            <p class="text-gray-800">{{ $program->created_at->format('d M Y H:i') }}</p>
                        </div>

                        <div>
                            <h4 class="font-medium text-gray-700">Terakhir diperbarui:</h4>
                            <p class="text-gray-800">{{ $program->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('program.edit', $program->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                            Edit Program
                        </a>
                        <form action="{{ route('program.destroy', $program->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600" onclick="return confirm('Yakin ingin menghapus program ini?')">
                                Hapus Program
                            </button>
                        </form>
                        <a href="{{ route('program.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
