<!DOCTYPE html>
<html>
<head>
    <title>Rincian Belanja</title>
    <style>
        /* Gaya dasar untuk tampilan PDF */
        body { font-family: Arial, sans-serif; }
    </style>
</head>
<body>
    <h1>Rincian Belanja</h1>
    <p><strong>Program:</strong> {{ $rincianBelanja->subKegiatan->kegiatan->program->nama_program }}</p>
    <p><strong>Kegiatan:</strong> {{ $rincianBelanja->subKegiatan->kegiatan->nama_kegiatan }}</p>
    <p><strong>Sub Kegiatan:</strong> {{ $rincianBelanja->subKegiatan->nama_sub_kegiatan }}</p>
    <p><strong>Kode Rekening:</strong> {{ $rincianBelanja->kode_rekening }}</p>
    <p><strong>Anggaran:</strong> {{ number_format($rincianBelanja->anggaran, 0, ',', '.') }} ({{ $terbilang }})</p>
    <p><strong>Untuk Pengeluaran:</strong> {{ $untukPengeluaran }}</p>
    <p><strong>Nomor ST:</strong> {{ $nomorSt }}</p>
    
    <!-- Informasi Pegawai -->
    <h2>Pegawai Terkait</h2>
    <p><strong>Kepala Dinas:</strong> {{ $kepalaDinas->Nama }}</p>
    <p><strong>PPTK:</strong> {{ $pptk->Nama }}</p>
    <p><strong>Bendahara:</strong> {{ $bendahara->Nama }}</p>
    <p><strong>Menerima:</strong> {{ $menerima->Nama }}</p>
</body>
</html>
