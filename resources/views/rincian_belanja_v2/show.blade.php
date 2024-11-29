<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Rincian Belanja') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-4">
        <table class="table table-bordered">
            <tr>
                <th>Program</th>
                <td>{{ $rincianBelanja->program->nama }}</td>
            </tr>
            <tr>
                <th>Kegiatan</th>
                <td>{{ $rincianBelanja->kegiatan->nama_kegiatan }}</td>
            </tr>
            <tr>
                <th>Sub Kegiatan</th>
                <td>{{ $rincianBelanja->subKegiatan->nama_sub_kegiatans }}</td>
            </tr>
            <tr>
                <th>Kode Rekening</th>
                <td>{{ $rincianBelanja->kodeRekening->nama_kode_rekening }}</td>
            </tr>
            <tr>
                <th>Anggaran</th>
                <td>{{ number_format($rincianBelanja->anggaran, 2) }}</td>
            </tr>
            <tr>
                <th>Nomor ST</th>
                <td>{{ $rincianBelanja->nomor_st }}</td>
            </tr>
            <tr>
                <th>Nomor SPD</th>
                <td>{{ $rincianBelanja->nomor_spd }}</td>
            </tr>
            <tr>
                <th>Untuk Pengeluaran</th>
                <td>{{ $rincianBelanja->untuk_pengeluaran }}</td>
            </tr>
            <tr>
                <th>Terbilang</th>
                <td>{{ $rincianBelanja->terbilang }}</td>
            </tr>
            <tr>
                <th>Kepala Dinas</th>
                <td>{{ $rincianBelanja->kepalaDinas->nama }}</td>
            </tr>
            <tr>
                <th>PPTK</th>
                <td>{{ $rincianBelanja->pptk->nama }}</td>
            </tr>
            <tr>
                <th>Bendahara</th>
                <td>{{ $rincianBelanja->bendahara->nama }}</td>
            </tr>
            <tr>
                <th>Nama Penerima / Pegawai</th>
                <td>{{ $rincianBelanja->pegawai->nama }}</td>
            </tr>
        </table>

        <a href="{{ route('rincian_belanja_v2.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</x-app-layout>
