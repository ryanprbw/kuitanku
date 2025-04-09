<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Kartu Kendali Kegiatan Perjalanan Dinas</title>
    <style>
        @page {
            size: 330mm 210mm;
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed;

        }

        .table th,
        .table td {
            border: 1px solid black;
            padding: 6px;
            word-wrap: break-word;
        }

        .table thead {
            display: table-header-group;
            background-color: #f2f2f2;
            text-align: center;
        }

        h3,
        h4 {
            page-break-after: avoid;
        }

        .table tfoot {
            display: table-row-group;
        }

        .table tr {
            page-break-inside: avoid;
        }

        .footer {
            margin-top: 20px;
            text-align: left;
        }

        .credit {

            position: fixed;
            bottom: 0px;
            right: 20px;
            font-size: 9px;
            color: rgb(197, 197, 197);
        }

        .signature-table {
            width: 100%;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="header" style="display: flex; align-items: center;">
        <!-- Menambahkan Logo di Sebelah Kiri -->
        <img src="{{ public_path('assets/tapin.png') }}" alt="Logo Tapin" style="height: 50%; margin-right: 15px;">
        <div>
            <h1 class="uppercase">DINAS KEPEDUDUKAN DAN PENCATATAN SIPIL</h1>
            <h2 class="uppercase">LAPORAN KARTU KENDALI KEGIATAN PERJALANAN DINAS</h2>
            <p>Periode: {{ $startDate ? date('d M Y', strtotime($startDate)) : '...' }} -
                {{ $endDate ? date('d M Y', strtotime($endDate)) : '...' }}</p>
        </div>
    </div>
    <div style="page-break-after: always;"></div>
    @foreach ($rincianBelanja as $key => $group)
        @php
            $firstItem = $group->first();
            $totalRealisasi = 0;
        @endphp

        @if (!$loop->first)
            <div style="page-break-before: always;"></div>
        @endif

        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td style="width: 20%; font-weight: bold;">Bidang / Sub. Bagian</td>
                <td>: {{ $firstItem->bidang->nama_bidang ?? 'Tidak Ada Data' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Program</td>
                <td>: {{ $firstItem->program->nama ?? 'Tidak Ada Data' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Kegiatan</td>
                <td>: {{ $firstItem->kegiatan->nama_kegiatan ?? 'Tidak Ada Data' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Sub Kegiatan</td>
                <td>: {{ $firstItem->subKegiatan->nama_sub_kegiatan ?? 'Tidak Ada Data' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Kode Rekening</td>
                <td>: {{ $firstItem->kodeRekening->nama_kode_rekening ?? 'Tidak Ada Data' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Anggaran Awal</td>
                <td>: Rp. {{ number_format($firstItem->kodeRekening->anggaran_awal ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Sisa Anggaran</td>
                <td>: Rp. {{ number_format($firstItem->kodeRekening->anggaran ?? 0, 0, ',', '.') }}</td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 55%;">Deskripsi</th>
                    <th style="width: 20%;">Realisasi</th>
                    <th style="width: 20%;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($group as $index => $item)
                    @php $totalRealisasi += $item->anggaran; @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td style="font-size: 10px;">{{ $item->untuk_pengeluaran }}</td>
                        <td>Rp. {{ number_format($item->anggaran, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align: center; font-weight: bold;">Total Realisasi</td>
                    <td style="font-weight: bold;">Rp. {{ number_format($totalRealisasi, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <div class="credit">
            <i class="ri-copyright-fill">
                Credit by. 19960702 202421 1 003 - Dinas Kependudukan dan Pencatatan Sipil, Kab. Tapin
            </i>
            Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}
        </div>
    @endforeach

    <table style="width: 100%; margin-top: 30px;">
        <tr>
            <td style="width: 25%; font-weight: bold;">Total Anggaran</td>
            <td style="width: 2%;">:</td>
            <td>Rp. {{ number_format($totalAnggaran, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div style="width: 100%; margin-top: 50px; text-align: center;">
        <table style="width: 100%; border-collapse: collapse; margin-top: 30px;">
            <tr>
                <td style="width: 50%; text-align: center;">
                    <strong>Mengetahui / Meyetujui :</strong><br>
                    <strong>Kepala Dinas Kependudukan dan Pencatatan Sipil</strong>
                    <br><br><br><br> <br><br><br><br>
                    <strong>{{ $kadis->nama ?? '-' }}</strong>
                    <br>
                    NIP. {{ $bendahara->nip ?? '-' }}
                </td>
                <td style="width: 50%; text-align: center;">
                    <strong>Rantau, {{ now()->format('d-m-Y ') }}</strong><br>
                    <strong>BENDAHARA PENGELUARAN SKPD</strong>
                    <br><br><br><br> <br><br><br><br>
                    <strong>{{ $bendahara->nama ?? '-' }}</strong> <!-- Ganti dengan nama bendahara -->
                    <br>
                    NIP : {{ $bendahara->nip ?? '-' }} <!-- Ganti dengan NIP bendahara -->
                </td>
            </tr>
        </table>
    </div>


</body>

</html>
