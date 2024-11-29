<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Bendahara') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('bendahara.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Tambah Bendahara</a>
                    <table class="min-w-full border-collapse table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b">Nama</th>
                                <th class="px-4 py-2 border-b">NIP</th>
                                <th class="px-4 py-2 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bendahara as $bd)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $bd->nama }}</td>
                                    <td class="px-4 py-2 border-b">{{ $bd->nip }}</td>
                                    <td class="px-4 py-2 border-b">
                                        <a href="{{ route('bendahara.edit', $bd->id) }}" class="text-yellow-500">Edit</a> | 
                                        <form action="{{ route('bendahara.destroy', $bd->id) }}" method="POST" style="display:inline;">
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
