<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Rincian Belanja Umum</title>
    <style>
        body {
            font-family: Arial, 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: auto;
            padding: 10px;
            border: 2px solid;
        }

        h1 {
            text-align: center;
            font-size: 32px;
            text-decoration: underline;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 5px;
            vertical-align: top;
        }

        th {
            text-align: left;
        }

        .section {
            margin-top: 20px;
            text-align: left;
        }

        .signature {
            border-top: 2px solid;
            margin-top: 10px;
            width: 100%;
            display: block;
        }

        .signature div {
            width: 48%;
            display: inline-block;
            vertical-align: top;
            text-align: center;

            padding-top: 5px;
        }

        .signature p {
            margin: 0px 0;
        }

        .nilai {
            margin-top: 20px;
            width: 100%;
        }

        .nilai div {
            width: 30%;
            /* Menentukan lebar div agar ada ruang untuk semua elemen */
            float: left;
            /* Membuat elemen berada berdampingan */
            text-align: left;
            margin-right: 2%;
            /* Menambahkan jarak antar div */
        }

        .nilai p {
            margin: 5px 0;
        }



        .bold {
            font-weight: bold;
        }

        .sebesar {
            font-weight: bold;
            text-transform: uppercase;
            /* border: 2px solid black; */

            margin-top: 20px;
            width: fit-content;
            text-align: center;
            align-content: center;
            /* display: inline-block; */
            font-size: 12pt;

        }

        .italic {
            font-style: italic;
        }

        .underline {
            text-decoration: underline;
        }

        .bold {
            font-weight: bold;
        }

        .border-bottom {
            border-bottom: 2px solid black;
        }
    </style>
</head>

<body>
    <div class="container">
        <table class="header" style="border-bottom: 2px solid black; width: 100%; table-layout: fixed;">
            <tr>
                <td style="width: 21%; font-weight: bold; : 2px solid black;">Urusan Pemerintahan</td>
                <td style="width: 1%; font-weight: bold; : 2px solid black;"> : </td>
                <td style=": 2px solid black;"><strong> PEMERINTAHAN WAJIB YANG TIDAK BERKAITAN DENGAN PELAYANAN DASAR</strong>
                </td>
            </tr>
            <tr>
                <td style="width: 21%; font-weight: bold; : 2px solid black;">Bidang Urusan</td>
                <td style="width: 1%; font-weight: bold; : 2px solid black;"> : </td>
                <td style=": 2px solid black;"><strong>URUSAN PEMERINTAHAN BIDANG ADMINISTRASI KEPENDUDUKAN DAN PENCATATAN
                    SIPIL</strong></td>
            </tr>
            <tr>
                <td style="width: 20%; font-weight: bold; : 2px solid black;">Unit Organisasi</td>
                <td style="width: 1%; font-weight: bold; : 2px solid black;"> : </td>
                <td style=": 2px solid black;"><strong>DINAS KEPENDUDUKAN & PENCATATAN SIPIL</strong></td>
            </tr>
            <tr>
                <td style="width: 20%; font-weight: bold; : 2px solid black;">Program</td>
                <td style="width: 1%; font-weight: bold; : 2px solid black;"> : </td>
                <td style=": 2px solid black;">
                    {{ $rincian->program->nama ?? '2.12.01 PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA' }}
                </td>
            </tr>
            <tr>
                <td style="width: 20%; font-weight: bold; : 2px solid black;">Kegiatan</td>
                <td style="width: 1%; font-weight: bold; : 2px solid black;"> : </td>
                <td style=": 2px solid black;">
                    {{ $rincian->kegiatan->nama_kegiatan ?? '5.1.02.03 Belanja Pemeliharaan' }}</td>
            </tr>
            <tr>
                <td style="width: 20%; font-weight: bold; : 2px solid black;">Sub Kegiatan</td>
                <td style="width: 1%; font-weight: bold; : 2px solid black;"> : </td>
                <td style=": 2px solid black;">
                    {{ $rincian->subKegiatan->nama_sub_kegiatan ?? 'Tidak ada Data' }}
                </td>
            </tr>
            <tr>
                <td style="width: 20%; font-weight: bold; : 2px solid black;">Kode Rekening</td>
                <td style="width: 1%; font-weight: bold; : 2px solid black;"> : </td>
                <td style=": 2px solid black;">{{ $rincian->kodeRekening->nama_kode_rekening ?? 'Tidak ada Data' }}
                </td>
            </tr>
            <tr>
                <td style="width: 20%; font-weight: bold; : 2px solid black;">No. BKU</td>
                <td style="width: 1%; font-weight: bold; : 2px solid black;"> : </td>
                <td style=": 2px solid black;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    /BK/Disdukcapil/2024</td>
            </tr>
        
        </table>

        <h1>KUITANSI</h1>
        <div class="section">
            <table style="width: 100%; border: none; table-layout: fixed;">
                <tr>
                    <td style="width: 21%; font-weight: ;">Sudah terima dari</td>
                    <td style="width: 1%;">:</td>
                    <td style="width: 82%;">BENDAHARA PENGELUARAN DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL KAB. TAPIN
                    </td>
                </tr>
                <tr>
                    <td style="width: 21%; font-weight: ;">Terbilang Rupiah</td>
                    <td style="width: 1%;">:</td>
                    <td style="width: 82%;" class="italic"><strong>{{ preg_replace('/([a-z])([A-Z])/', '$1 $2', $rincian->terbilang_rupiah) }}</strong></td>
  
                </tr>
                <tr>
                    <td style="width: 21%; font-weight: ;">Untuk Pengeluaran</td>
                    <td style="width: 1%;">:</td>
                    <td style="width: 82%;">{{ $rincian->untuk_pengeluaran }}</td>
                </tr>
            </table>
        </div>

        <table rowspan="3" class="section" style="width: 90%; table-layout: fixed;">
            {{-- <tr>
                <td style="font-style: italic; text-decoration: underline; font-weight: bold; width: 33%;">Total Pajak
                </td>
                <td style="width: 33%;">: Rp {{ number_format($rincian->total_pajak) }}</td>

            </tr> --}}
            <tr>
                <td style="font-style: italic; text-decoration: underline; font-weight: bold; width: 20%;">Bruto</td>
                <td style="width: 1%;">:</td>
                <td style="width: 30%;">Rp {{ number_format($rincian->bruto, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Pajak</td>
                <td>:</td>
  
                <td >Rp {{ number_format($rincian->total_pajak, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>DPP</td>
                <td>:</td>
  
                <td >Rp {{ number_format($rincian->dpp, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Potongan PPh 21</td>
                <td>:</td>
                <td >Rp {{ number_format($rincian->pph21, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Potongan PPh 22</td>
                <td>:</td>
                <td >Rp {{ number_format($rincian->pph22, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Potongan PPh 23</td>
                <td>:</td>
                <td >Rp {{ number_format($rincian->pph23, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Potongan PPN</td>
                <td>:</td>
                <td >Rp {{ number_format($rincian->ppn, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Pajak Daerah PBJT</td>
                <td>:</td>
                <td >Rp {{ number_format($rincian->pbjt, 0, ',', '.') }}</td>

            </tr>
            <tr>
                <td class="underline italic"><strong>Netto</strong></td>
                <td>:</td>
                <td><strong>Rp {{ number_format($rincian->netto, 0, ',', '.') }},-</strong></td>


                <td rowspan="2" style="  padding: 10px; width: 10%; table-layout: relative; ">
                    <p>&nbsp;</p>
                </td>
               
                <td rowspan="2"
                    style=" border: 2px solid black; padding: 10px; width: 60%; table-layout: relative; ">

                    <strong>Telah diperiksa oleh PPK-SKPD</strong><br>
                    <p>
                        Tanggal : ..............
                    </p>
                    Paraf :
                </td>
            </tr>
            
     
            <tr class="italic">
                <td style="border-top: 2px solid black; border-bottom: 2px solid black; border-left: 2px solid black;">
                    <strong class="sebesar" >SEBESAR</strong>
                </td>
                <td style="border-top: 2px solid black; border-bottom: 2px solid black; ">:</td>
                <td style="border-top: 2px solid black; border-bottom: 2px solid black; border-right: 2px solid black;">
                    <strong class="sebesar" >
                        {{ number_format($rincian->sebesar, 0, ',', '.') }},-</strong>
                </td>
            </tr>

            
        </table>
        <!-- Signature Section -->
        <div class="signature">
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
                <br><br><br><br>
                <p class="underline"><strong>{{ $rincian->bendahara->nama ?? '-' }}</strong></p>
                <p class="bold">NIP. {{ $rincian->bendahara->nip ?? '-' }}</p>
            </div>
            <div style="padding-top: 40px">
                <p>&nbsp;</p>
                <p>Rantau, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $rincian->bulan ?? '-' }} {{ now()->year }}</p>


                <p>Penerima,</p>
                <br><br><br><br>
                <p>Nama : {{ $rincian->penerima->nama ?? '-' }}</p>
                <p>No. Rekening : {{ $rincian->penerima->nomor_rekening ?? '-' }}</p>
                <p>Nama Bank : {{ $rincian->penerima->nama_bank ?? '-' }}</p>
            </div>
        </div>

    </div>
</body>
</html>
