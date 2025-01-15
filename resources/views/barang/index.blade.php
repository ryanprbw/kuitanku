<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('barang.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                        Tambah Barang
                    </a>

                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="border border-gray-200 px-4 py-2">No</th>
                                <th class="border border-gray-200 px-4 py-2">Nama Barang</th>
                                <th class="border border-gray-200 px-4 py-2">Harga Satuan</th>
                                <th class="border border-gray-200 px-4 py-2">Jumlah</th>
                                <th class="border border-gray-200 px-4 py-2">Nilai Saldo</th>
                                <th class="border border-gray-200 px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barang as $index => $item)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $item->nama_barang }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ number_format($item->harga_satuan, 2) }}
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $item->jumlah }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ number_format($item->nilai_saldo, 2) }}
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2">
                                        <a href="{{ route('barang.show', $item->id) }}"
                                            class="text-blue-500 hover:underline">Detail Barang</a>
                                        <a href="{{ route('barang.edit', $item->id) }}"
                                            class="text-green-500 hover:underline ml-2">Edit Barang</a>
                                        <form action="{{ route('barang.destroy', $item->id) }}" method="POST"
                                            class="inline-block ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">Hapus Barang</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border border-gray-200 px-4 py-2 text-center">Tidak ada data
                                        barang.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>