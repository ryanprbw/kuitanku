<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kartu Kendali Kegiatan</title>
    <style>
        @page {
            size: 330mm 210mm;
            margin: 15mm;

            /* Menampilkan nomor halaman di setiap halaman */

        }






        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: avoid;
        }

        .table th,
        .table td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
        }

        h3,
        h4 {
            page-break-after: avoid;
        }

        /* Nomor halaman di pojok kanan bawah */
        .credit {
            position: fixed;
            bottom: 0px;
            right: 20px;
            font-size: 11px;
            color: rgb(106, 106, 106);
        }
    </style>
</head>

<body>
    <div class="header" style="display: flex; align-items: center;">
        <!-- Menambahkan Logo di Sebelah Kiri -->
        {{-- <img src="{{ public_path('assets/tapin.png') }}" alt="Logo Tapin" style="height: 80px; margin-right: 15px;"> --}}
        <div>
            <h3 class="uppercase">DINAS KEPEDUDUKAN DAN PENCATATAN SIPIL</h3>
            <h2 class="uppercase">LAPORAN KARTU KENDALI KEGIATAN</h2>
            <p>Periode: {{ $startDate ? date('d M Y', strtotime($startDate)) : '...' }} -
                {{ $endDate ? date('d M Y', strtotime($endDate)) : '...' }}</p>
        </div>
    </div>


    @foreach ($rincianBelanja as $key => $group)
        @php
            $firstItem = $group->first();
        @endphp

        <!-- Memulai setiap bidang pada halaman baru -->
        <div style="page-break-before: always;">
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
                <tr>
                    <td style="width: 12%; font-weight: bold;">Bidang / Sub. Bagian</td>
                    <td style="width: 2%;">:</td>
                    <td>{{ $firstItem->bidang->nama_bidang ?? 'Tidak Ada Data' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Program</td>
                    <td>:</td>
                    <td>{{ $firstItem->program->nama ?? 'Tidak Ada Data' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Kegiatan</td>
                    <td>:</td>
                    <td>{{ $firstItem->kegiatan->nama_kegiatan ?? 'Tidak Ada Data' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Sub Kegiatan</td>
                    <td>:</td>
                    <td>{{ $firstItem->subKegiatan->nama_sub_kegiatan ?? 'Tidak Ada Data' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Kode Rekening</td>
                    <td>:</td>
                    <td>{{ $firstItem->kodeRekening->nama_kode_rekening ?? 'Tidak Ada Data' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Anggaran Awal</td>
                    <td>:</td>
                    <td>Rp {{ number_format($firstItem->kodeRekening->anggaran_awal, 0, ',', '.') }}</td>
                </tr>
            </table>

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Deskripsi</th>
                        <th>Realisasi</th>
                        <th>Sisa Anggaran</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($group as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->untuk_pengeluaran }}</td>
                            <td>Rp {{ number_format($item->anggaran, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($firstItem->kodeRekening->anggaran, 0, ',', '.') }}</td>
                            <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="credit">
            <i class="ri-copyright-fill">
                Credit by. 19960702 202421 1 003 - Dinas Kependudukan dan Pencatatan Sipil, Kab. Tapin
            </i>
            Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}
        </div>
    @endforeach



    <div class="footer">
        <h3>Total Anggaran: Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</h3>
    </div>


</body>

</html>
