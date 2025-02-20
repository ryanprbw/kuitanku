<!-- laporan/cetak.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Belanja</title>
</head>

<body>
    <h1>Laporan Belanja</h1>
    <h3>Total Belanja yang digunakan: Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</h3>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>No.</th>
                <th>Program</th>
                <th>Kegiatan</th>
                <th>Sub Kegiatan</th>
                <th>Kode Rekening</th>
                <th>Bidang</th>
                <th>Rincian Belanja Umum</th>
                <th>Anggaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rincianBelanja as $group)
                @foreach ($group as $rincian)
                    <tr>
                        <td>{{ $loop->parent->iteration }}</td>
                        <td>{{ $rincian->program->nama ?? 'Tidak ada Program' }}</td>
                        <td>{{ $rincian->kegiatan->nama_kegiatan ?? 'Tidak ada Kegiatan' }}</td>
                        <td>{{ $rincian->subKegiatan->nama_sub_kegiatan ?? 'Tidak ada Sub Kegiatan' }}</td>
                        <td>{{ $rincian->kodeRekening->nama_kode_rekening ?? 'Tidak ada Kode Rekening' }}</td>
                        <td>{{ $rincian->bidang->nama_bidang ?? 'Tidak ada Bidang' }}</td>
                        <td>{{ $rincian->untuk_pengeluaran }}</td>
                        <td>Rp {{ number_format($rincian->anggaran, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
