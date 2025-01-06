<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pegawai') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">
        <!-- Flash Message -->
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Total Penerima: {{ $pegawais->count() }}</h3>
            <a href="{{ route('pegawais.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Tambah Penerima Kuitansi
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm">
                    <tr>
                        <th class="px-6 py-3">NIP</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Pangkat</th>
                        <th class="px-6 py-3">Jabatan</th>
                        <th class="px-6 py-3">Bank</th>
                        <th class="px-6 py-3">Nomor Rekening</th>
                        <th class="px-6 py-3">Bidang</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($pegawais as $pegawai)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4">{{ $pegawai->nip ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $pegawai->nama }}</td>
                            <td class="px-6 py-4">{{ $pegawai->pangkat }}</td>
                            <td class="px-6 py-4">{{ $pegawai->jabatan }}</td>
                            <td class="px-6 py-4">{{ $pegawai->nama_bank }}</td>
                            <td class="px-6 py-4">{{ $pegawai->nomor_rekening }}</td>
                            <td class="px-6 py-4">{{ $pegawai->bidang->nama_bidang ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('pegawais.edit', $pegawai->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Edit</a>
                                <form action="{{ route('pegawais.destroy', $pegawai->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus pegawai ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada data pegawai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $pegawais->links() }}
        </div>
    </div>
</x-app-layout>
