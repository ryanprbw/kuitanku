<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Rincian Belanja Umum</title>
    <style>
        /* Resetting margin dan padding global untuk seluruh body */
        body {
            font-family: Arial, 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        /* Container utama untuk konten */
        .container {
            margin-left: -3%;
            margin-right: -3%;
            padding: 20px 10px 20px 10px;
            border: 2px solid #000;
        }

        /* Gaya untuk heading utama */
        h1 {
            text-align: center;
            font-size: 32px;
            text-decoration: underline;
            margin: 10px 0;
        }

        /* Pengaturan untuk tabel */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        /* Padding dan alignment untuk table cell */
        td,
        th {
            padding: 5px;
            vertical-align: top;
        }

        /* Alignment text pada header */
        th {
            text-align: left;
        }

        /* Pengaturan untuk section */
        .section {
            margin-top: 20px;
            text-align: left;
        }

        /* Gaya untuk signature area */
        .signature {
            border-top: 2px solid #000;
            margin-top: 10px;
            width: 100%;
            display: block;
        }

        /* Gaya untuk setiap div di dalam signature */
        .signature div {
            width: 48%;
            display: inline-block;
            vertical-align: top;
            text-align: center;
            padding-top: 5px;
        }

        /* Margin pada paragraf signature */
        .signature p {
            margin: 0;
        }

        /* Gaya untuk div nilai */
        .nilai {
            margin-top: 20px;
            width: 100%;
        }

        /* Gaya untuk setiap div dalam .nilai */
        .nilai div {
            width: 30%;
            /* Menentukan lebar div agar ada ruang untuk semua elemen */
            float: left;
            /* Membuat elemen berada berdampingan */
            text-align: left;
            margin-right: 2%;
            /* Menambahkan jarak antar div */
        }

        /* Margin pada paragraf di dalam .nilai */
        .nilai p {
            margin: 5px 0;
        }

        /* Gaya untuk kolom dengan text justify */
        .untuk_pengeluaran {
            text-align: justify;
            /* Menggunakan text-align justify, bukan text-justify */
        }

        /* Gaya teks dengan bold */
        .bold {
            font-weight: bold;
        }

        /* Gaya untuk bagian 'Sebesar' */
        .sebesar {
            font-weight: bold;
            text-transform: uppercase;
            text-align: left;
            font-size: 12pt;
            line-height: 1.5;
            padding-left: 10px;

        }

        /* Gaya untuk nomor ST */
        .nomorst {
            margin-top: 20px;
            padding-top: 20px;
        }

        /* Gaya untuk italic text */
        .italic {
            font-style: italic;
        }

        /* Gaya untuk underline */
        .underline {
            text-decoration: underline;
        }

        /* Gaya border bawah pada elemen tertentu */
        .border-bottom {
            border-bottom: 2px solid black;
        }

        /* Gaya untuk text justify */
        .justify-text {
            text-align: justify;
        }

        table.section {
            width: 100%;
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
        }

        td,
        th {
            padding: 5px;
            vertical-align: top;
            text-align: left;

        }
    </style>
</head>

<body>
    <div class="container">
        <table class="header" style="border-collapse: collapse; width: 100%;">
            <tr>
                <td style="width: 20%; font-weight: bold;">Urusan Pemerintahan</td>
                <td style="width: 1%; font-weight: bold;">:</td>
                <td colspan="8"><strong>PEMERINTAHAN WAJIB YANG TIDAK BERKAITAN DENGAN PELAYANAN DASAR</strong></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Bidang Urusan</td>
                <td style="font-weight: bold;">:</td>
                <td colspan="8"><strong>URUSAN PEMERINTAHAN BIDANG ADMINISTRASI KEPENDUDUKAN DAN PENCATATAN
                        SIPIL</strong></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Unit Organisasi</td>
                <td style="font-weight: bold;">:</td>
                <td colspan="8"><strong>DINAS KEPENDUDUKAN & PENCATATAN SIPIL</strong></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Program</td>
                <td style="font-weight: bold;">:</td>
                <td colspan="8">
                    {{ $rincian->program->nama ?? '2.12.01 PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA' }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Kegiatan</td>
                <td style="font-weight: bold;">:</td>
                <td colspan="8">{{ $rincian->kegiatan->nama_kegiatan ?? '5.1.02.03 Belanja Pemeliharaan' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Sub Kegiatan</td>
                <td style="font-weight: bold;">:</td>
                <td colspan="8">{{ $rincian->subKegiatan->nama_sub_kegiatan ?? 'Tidak ada Data' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Kode Rekening</td>
                <td style="font-weight: bold;">:</td>
                <td colspan="8">{{ $rincian->kodeRekening->nama_kode_rekening ?? 'Tidak ada Data' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; width: 20%;">No. BKU</td>
                <td style="font-weight: bold; width: 2%;">:</td>
                <td style="text-align: left;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/BK/Disdukcapil/{{ date('Y') }}</td>
            </tr>

            <!-- Border bawah yang mencakup seluruh lebar tabel -->
            <tr class="italic">
                <td colspan="10" style="border-bottom: 2px solid black; width: 100%;"></td>
            </tr>

        </table>


        <h1>KUITANSI</h1>

        <table class=" section">

            <tr>
                <td style=" font-weight: bold; width: 20%;">Sudah terima dari</td>
                <td style="width: 1%;">:</td>
                <td colspan="8">BENDAHARA PENGELUARAN DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL KAB. TAPIN</td>
            </tr>
            <tr>
                <td>Terbilang Rupiah</td>
                <td>:</td>
                <td colspan="8" class="italic">
                    <strong>{{ preg_replace('/([a-z])([A-Z])/', '$1 $2', $rincian->terbilang_rupiah) }}</strong>
                </td>
            </tr>
            <tr class="untuk_pengeluaran">
                <td>Untuk Pengeluaran</td>
                <td>:</td>
                <td class="justify-text" colspan="8">{{ $rincian->untuk_pengeluaran }}</td>
            </tr>
            <tr>
                <td style="font-style: italic; text-decoration: underline; font-weight: bold;">Bruto</td>
                <td>:</td>
                <td colspan="9">Rp. {{ number_format($rincian->bruto, 0, ',', '.') }} </td>
            </tr>
            <tr>
                <td>Total Pajak</td>
                <td>:</td>
                <td colspan="9">Rp. {{ number_format($rincian->total_pajak, 0, ',', '.') }} </td>
            </tr>
            <tr>
                <td>DPP</td>
                <td>:</td>
                <td colspan="9">Rp. {{ number_format($rincian->dpp, 0, ',', '.') }} </td>
            </tr>
            <tr>
                <td>Potongan PPh 21</td>
                <td>:</td>
                <td colspan="9">Rp. {{ number_format($rincian->pph21, 0, ',', '.') }} </td>
            </tr>
            <tr>
                <td>Potongan PPh 22</td>
                <td>:</td>
                <td colspan="9">Rp. {{ number_format($rincian->pph22, 0, ',', '.') }} </td>
            </tr>
            <tr>
                <td>Potongan PPh 23</td>
                <td>:</td>
                <td colspan="9">Rp. {{ number_format($rincian->pph23, 0, ',', '.') }} </td>
            </tr>
            <tr>
                <td>Potongan PPN</td>
                <td>:</td>
                <td colspan="9">Rp. {{ number_format($rincian->ppn, 0, ',', '.') }} </td>
            </tr>
            <tr>
                <td>Pajak Daerah PBJT</td>
                <td>:</td>
                <td colspan="9">Rp. {{ number_format($rincian->pbjt, 0, ',', '.') }} </td>
            </tr>
            <tr>
                <td class="underline italic bold">Netto</td>
                <td>:</td>
                <td class="bold" colspan="5">Rp. {{ number_format($rincian->netto, 0, ',', '.') }} </td>
                <td style="border-top: 2px solid; border-left: 2px solid; border-right: 2px solid;" colspan="3">
                    Telah diperiksa oleh PPK-SKPD<br>
                </td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td colspan="5"></td>


                <td style=" border-left: 2px solid; border-right: 2px solid;" colspan="3">Tanggal:
                    ............................</td>
                <td></td>
            </tr>
            <tr class="italic">

                <td class="sebesar" style="border-top: 2px solid; border-bottom: 2px solid; border-left: 2px solid;">
                    Sebesar</td>
                <td class="sebesar" style="border-top: 2px solid; border-bottom: 2px solid;">:</td>
                <td class="sebesar" style=" border-top: 2px solid; border-right: 2px solid; border-bottom: 2px solid;"
                    colspan="2">{{ number_format($rincian->sebesar, 0, ',', '.') }},-</td>
                <td colspan="3"></td>
                <td style=" border-left: 2px solid; border-right: 2px solid; border-bottom: 2px solid; padding-left: 60px;"
                    colspan="3">Paraf: <br>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="4"></td>
                <td colspan="3"></td>
                <td></td>
            </tr>




        </table>





        <!-- Signature Section -->
        <div class=" signature">
            <div>

                <p>Mengetahui & Menyetujui ;</p>
                <p>KEPALA DINAS KEPENDUDUKAN & PENCATATAN SIPIL</p>
                <p>KABUPATEN TAPIN</p>
                <br><br><br><br><br><br>
                <p style="text-decoration: underline"><strong>{{ $rincian->kepalaDinas->nama ?? '-' }}</strong></p>
                <p><strong>NIP. {{ $rincian->kepalaDinas->nip ?? '-' }}</strong></p>
            </div>

            <div>
                <p>&nbsp;</p>
                <p>PEJABAT PELAKSANA TEKNIS KEGIATAN,</p>
                <p>DINAS KEPENDUDUKAN & PENCATATAN SIPIL</p>
                <br><br><br><br> <br> <br>
                <p>NAMA : {{ $rincian->pptk->nama ?? '-' }}</p>
                <p>NIP : {{ $rincian->pptk->nip ?? '-' }}</p>
                <p>BIDANG : {{ $rincian->pptk->bidang->nama_bidang ?? 'N/A' }}</p>
            </div>
            <div style="padding-top: 40px">
                <p>Dibayar Oleh,</p>
                <p>BENDAHARA PENGELUARAN <br>
                    DINAS KEPENDUDUKAN & PENCATATAN SIPIL <br>
                    KABUPATEN TAPIN</p>
                <br><br><br><br><br><br>
                <p class="underline"><strong>{{ $rincian->bendahara->nama ?? '-' }}</strong></p>
                <p class="bold">NIP. {{ $rincian->bendahara->nip ?? '-' }}</p>
            </div>
            <div style="padding-top: 40px">
                <p>&nbsp;</p>
                <p>Rantau,
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rincian->bulan ?? '..........' }}
                    {{ now()->year }}</p>


                <p>Penerima,</p>
                <br><br><br><br><br><br>
                <p>Nama : {{ $rincian->penerima->nama ?? '-' }}</p>
                <p>No. Rekening : {{ $rincian->penerima->nomor_rekening ?? '-' }}</p>
                <p>Nama Bank : {{ $rincian->penerima->nama_bank ?? '-' }}</p>
            </div>
        </div>

    </div>
</body>

</html>
