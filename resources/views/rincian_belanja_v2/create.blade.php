<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Rincian Belanja') }}
        </h2>
    </x-slot>


    <div class="container">
        <h1 class="mb-4">Tambah Rincian Belanja</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('rincian_belanja_v2.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="program_id">Program</label>
                <select class="form-control @error('program_id') is-invalid @enderror" name="program_id" id="program_id"
                    required>
                    <option value="">Pilih Program</option>
                    @foreach ($programs as $program)
                        <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                            {{ $program->nama }}</option>
                    @endforeach
                </select>
                @error('program_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="kegiatan_id">Kegiatan</label>
                <select class="form-control @error('kegiatan_id') is-invalid @enderror" name="kegiatan_id"
                    id="kegiatan_id" required>
                    <option value="">Pilih Kegiatan</option>
                    @foreach ($kegiatans as $kegiatan)
                        <option value="{{ $kegiatan->id }}" {{ old('kegiatan_id') == $kegiatan->id ? 'selected' : '' }}>
                            {{ $kegiatan->nama_kegiatan }}</option>
                    @endforeach
                </select>
                @error('kegiatan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="sub_kegiatan_id">Sub Kegiatan</label>
                <select class="form-control @error('sub_kegiatan_id') is-invalid @enderror" name="sub_kegiatan_id"
                    id="sub_kegiatan_id" required>
                    <option value="">Pilih Sub Kegiatan</option>
                    @foreach ($subKegiatans as $subKegiatan)
                        <option value="{{ $subKegiatan->id }}"
                            {{ old('sub_kegiatan_id') == $subKegiatan->id ? 'selected' : '' }}>
                            {{ $subKegiatan->nama_sub_kegiatans }}</option>
                    @endforeach
                </select>
                @error('sub_kegiatan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="kode_rekening_id">Kode Rekening</label>
                <select class="form-control @error('kode_rekening_id') is-invalid @enderror" name="kode_rekening_id"
                    id="kode_rekening_id" required>
                    <option value="">Pilih Kode Rekening</option>
                    @foreach ($kodeRekeningBidangs as $kodeRekening)
                        <option value="{{ $kodeRekening->id }}"
                            {{ old('kode_rekening_id') == $kodeRekening->id ? 'selected' : '' }}>
                            {{ $kodeRekening->kodeRekening }} -
                            {{ number_format($kodeRekening->anggaran, 2) }} -
                            {{ $kodeRekening->bidang->nama_bidang }}
                        </option>
                    @endforeach
                </select>
                @error('kode_rekening_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="form-group mb-3">
                <label for="anggaran">Anggaran</label>
                <input type="number" class="form-control @error('anggaran') is-invalid @enderror" name="anggaran"
                    id="anggaran" value="{{ old('anggaran') }}" required oninput="updateTerbilang()">
                @error('anggaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="form-group mb-3">
                <label for="terbilang">Terbilang</label>
                <input type="text" class="form-control @error('terbilang') is-invalid @enderror" name="terbilang"
                    id="terbilang" value="{{ old('terbilang') }}" required>
                @error('terbilang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="untuk_pengeluaran">Untuk Pengeluaran</label>
                <input type="text" class="form-control @error('untuk_pengeluaran') is-invalid @enderror"
                    name="untuk_pengeluaran" id="untuk_pengeluaran" value="{{ old('untuk_pengeluaran') }}" required>
                @error('untuk_pengeluaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="nomor_st">Nomor ST</label>
                <input type="text" class="form-control @error('nomor_st') is-invalid @enderror" name="nomor_st"
                    id="nomor_st" value="{{ old('nomor_st') }}" required>
                @error('nomor_st')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="tanggal_st">Tanggal ST</label>
                <input type="date" class="form-control @error('tanggal_st') is-invalid @enderror" name="tanggal_st"
                    id="tanggal_st" value="{{ old('tanggal_st') }}" required>
                @error('tanggal_st')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="nomor_spd">Nomor SPD</label>
                <input type="text" class="form-control @error('nomor_spd') is-invalid @enderror" name="nomor_spd"
                    id="nomor_spd" value="{{ old('nomor_spd') }}" required>
                @error('nomor_spd')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="tanggal_spd">Tanggal SPD</label>
                <input type="date" class="form-control @error('tanggal_spd') is-invalid @enderror"
                    name="tanggal_spd" id="tanggal_spd" value="{{ old('tanggal_spd') }}" required>
                @error('tanggal_spd')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>



            <div class="form-group mb-3">
                <label for="kepala_dinas_id">Kepala Dinas</label>
                <select class="form-control @error('kepala_dinas_id') is-invalid @enderror" name="kepala_dinas_id"
                    id="kepala_dinas_id" required>
                    <option value="">Pilih Kepala Dinas</option>
                    @foreach ($kepalaDinas as $kepalaDinas)
                        <option value="{{ $kepalaDinas->id }}"
                            {{ old('kepala_dinas_id') == $kepalaDinas->id ? 'selected' : '' }}>
                            {{ $kepalaDinas->nama }}</option>
                    @endforeach
                </select>
                @error('kepala_dinas_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="pptk_id">PPTK</label>
                <select class="form-control @error('pptk_id') is-invalid @enderror" name="pptk_id" id="pptk_id"
                    required>
                    <option value="">Pilih PPTK</option>
                    @foreach ($pptks as $pptk)
                        <option value="{{ $pptk->id }}" {{ old('pptk_id') == $pptk->id ? 'selected' : '' }}>
                            {{ $pptk->nama }}</option>
                    @endforeach
                </select>
                @error('pptk_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="bendahara_id">Bendahara</label>
                <select class="form-control @error('bendahara_id') is-invalid @enderror" name="bendahara_id"
                    id="bendahara_id" required>
                    <option value="">Pilih Bendahara</option>
                    @foreach ($bendaharas as $bendahara)
                        <option value="{{ $bendahara->id }}"
                            {{ old('bendahara_id') == $bendahara->id ? 'selected' : '' }}>{{ $bendahara->nama }}
                        </option>
                    @endforeach
                </select>
                @error('bendahara_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="pegawai_id">Pegawai</label>
                <select class="form-control @error('pegawai_id') is-invalid @enderror" name="pegawai_id"
                    id="pegawai_id" required>
                    <option value="">Pilih Pegawai</option>
                    @foreach ($pegawais as $pegawai)
                        <option value="{{ $pegawai->id }}"
                            {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama }}</option>
                    @endforeach
                </select>
                @error('pegawai_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>


</x-app-layout>


<script>
    // Fungsi untuk mengubah angka menjadi terbilang
    function numberToWords(number) {
        const ones = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan"];
        const tens = ["", "", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan",
            "sembilan"
        ]; // No need for "sepuluh"
        const tensSpecial = ["sepuluh", "sebelas", "dua belas", "tiga belas", "empat belas", "lima belas", "enam belas",
            "tujuh belas", "delapan belas", "sembilan belas"
        ];
        const thousands = ["", "ribu", "juta", "miliar", "triliun"];

        if (number == 0) return "nol rupiah";

        let words = '';
        let group = 0;

        // Mengonversi angka ke dalam kata-kata
        while (number > 0) {
            let n = number % 1000;
            if (n > 0) {
                let groupWords = '';
                if (n >= 100) {
                    groupWords += ones[Math.floor(n / 100)] + " ratus ";
                    n %= 100;
                }

                // Menangani angka 10-19
                if (n >= 10 && n <= 19) {
                    groupWords += tensSpecial[n - 10] + " ";
                    n = 0;
                }

                // Menangani angka 20 ke atas
                if (n >= 20) {
                    groupWords += tens[Math.floor(n / 10)] + " puluh ";
                    n %= 10;
                }

                // Menambahkan angka satuan (1-9)
                if (n > 0) {
                    groupWords += ones[n];
                }
                words = groupWords + " " + thousands[group] + " " + words;
            }
            group++;
            number = Math.floor(number / 1000);
        }

        // Menambahkan kata "rupiah" pada akhir kalimat terbilang
        return toTitleCase(words.trim() + " rupiah");
    }

    // Fungsi untuk mengubah string menjadi kapitalisasi setiap kata
    function toTitleCase(str) {
        return str.replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }

    // Fungsi untuk mengupdate kolom terbilang secara otomatis
    function updateTerbilang() {
        const anggaran = document.getElementById('anggaran').value;
        const terbilangField = document.getElementById('terbilang');
        if (anggaran) {
            terbilangField.value = numberToWords(parseInt(anggaran));
        } else {
            terbilangField.value = '';
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#kode_rekening_id').change(function () {
            const kodeRekeningId = $(this).val();

            if (kodeRekeningId) {
                $.ajax({
                    url: `/get-related-data/${kodeRekeningId}`,
                    type: 'GET',
                    success: function (data) {
                        $('#program_id').val(data.program || 'Tidak ditemukan');
                        $('#kegiatan_id').val(data.kegiatan || 'Tidak ditemukan');
                        $('#sub_kegiatan_id').val(data.sub_kegiatan || 'Tidak ditemukan');
                    },
                    error: function () {
                        alert('Gagal mengambil data terkait. Pastikan Anda memilih Kode Rekening yang valid.');
                    }
                });
            } else {
                $('#program_id').val('');
                $('#kegiatan_id').val('');
                $('#sub_kegiatan_id').val('');
            }
        });
    });
</script>

