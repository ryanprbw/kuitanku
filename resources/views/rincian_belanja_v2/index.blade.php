<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rincian Belanja') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-4">
        <a href="{{ route('rincian_belanja_v2.create') }}" class="btn btn-primary mb-3">Tambah Rincian Belanja</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Program</th>
                    <th>Kegiatan</th>
                    <th>Sub Kegiatan</th>
                    <th>Kode Rekening</th>
                    <th>Anggaran</th>
                    <th>Nomor ST</th>
                    <th>Nomor SPD</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rincianBelanja as $item)
                    <tr>
                        <td>{{ $item->program->nama }}</td>
                        <td>{{ $item->kegiatan->nama_kegiatan }}</td>
                        <td>{{ $item->subKegiatan->nama_sub_kegiatans }}</td>
                        <td>{{ $item->kodeRekening->nama_kode_rekening }}</td>
                        <td>{{ number_format($item->anggaran, 2) }}</td>
                        <td>{{ $item->nomor_st }}</td>
                        <td>{{ $item->nomor_spd }}</td>
                        <td>
                            <a href="{{ route('rincian_belanja_v2.show', $item->id) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('rincian_belanja_v2.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            @if(Auth::user()->role !== 'bidang')
                            <form action="{{ route('rincian_belanja_v2.destroy', $item->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
