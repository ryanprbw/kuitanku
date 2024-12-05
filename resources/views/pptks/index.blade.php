<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar PPTK') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('pptks.create') }}" class="text-blue-600 hover:text-blue-900">Tambah PPTK</a>

                    <div class="mt-4">
                        <h3 class="text-lg font-semibold">Total PPTK: {{ $totalPptk }}</h3>
                        <table class="min-w-full mt-4 table-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border">Nama</th>
                                    <th class="px-4 py-2 border">NIP</th>
                                    <th class="px-4 py-2 border">Bidang</th>
                                    <th class="px-4 py-2 border">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pptks as $pptk)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $pptk->nama }}</td>
                                    <td class="px-4 py-2 border">{{ $pptk->nip }}</td>
                                    <td class="px-4 py-2 border">{{ $pptk->bidang->nama_bidang }}</td>
                                    <td class="px-4 py-2 border">
                                        <a href="{{ route('pptks.edit', $pptk->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a> |
                                        <form action="{{ route('pptks.destroy', $pptk->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $pptks->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>