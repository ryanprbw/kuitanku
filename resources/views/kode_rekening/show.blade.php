<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Kode Rekening') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 mt-6">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold text-lg">Sub Kegiatan:</h3>
                    <p class="text-gray-700">{{ $kodeRekening->subKegiatan->nama_sub_kegiatan ?? '-' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Nama Kode Rekening:</h3>
                    <p class="text-gray-700">{{ $kodeRekening->nama_kode_rekening }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Bidang:</h3>
                    <p class="text-gray-700">{{ $kodeRekening->bidang->nama_bidang ?? '-' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Anggaran:</h3>
                    <p class="text-gray-700">Rp {{ number_format($kodeRekening->anggaran, 2, ',', '.') }}</p>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('kode_rekening.index') }}" class="btn btn-secondary">Kembali</a>
                <a href="{{ route('kode_rekening.edit', $kodeRekening->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('kode_rekening.destroy', $kodeRekening->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
