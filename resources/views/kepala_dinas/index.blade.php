<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kepala Dinas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('kepala_dinas.create') }}" class="bg-blue-500 text-black px-4 py-2 rounded mb-4">Tambah Kepala Dinas</a>
                    <table class="min-w-full border-collapse table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b">Nama</th>
                                <th class="px-4 py-2 border-b">NIP</th>
                                <th class="px-4 py-2 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kepala_dinas as $kd)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $kd->nama }}</td>
                                    <td class="px-4 py-2 border-b">{{ $kd->nip }}</td>
                                    <td class="px-4 py-2 border-b">
                                        <a href="{{ route('kepala_dinas.edit', $kd->id) }}" class="text-yellow-500">Edit</a> | 
                                        <form action="{{ route('kepala_dinas.destroy', $kd->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
