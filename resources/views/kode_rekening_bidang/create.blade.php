<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kode Rekening Bidang') }}
        </h2>
    </x-slot>

   
    <div class="container">
        <h1>Tambah Kode Rekening Bidang</h1>

        <form action="{{ route('kode-rekening-bidang.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="kode_rekenings_id">Kode Rekening</label>
                <select name="kode_rekenings_id" id="kode_rekenings_id" class="form-control">
                    @foreach($kodeRekenings as $kodeRekening)
                        <option value="{{ $kodeRekening->id }}">{{ $kodeRekening->nama_kode_rekening }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="bidang_id">Bidang</label>
                <select name="bidang_id" id="bidang_id" class="form-control">
                    @foreach($bidangs as $bidang)
                        <option value="{{ $bidang->id }}">{{ $bidang->nama_bidang }}</option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="form-group mt-4">
                <label for="nama_kode_rekening">Nama Kode Rekening</label>
                <input type="text" name="nama_kode_rekening" id="nama_kode_rekening" class="form-control" value="{{ old('nama_kode_rekening') }}">
                @error('nama_kode_rekening')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div> --}}

            <div class="form-group">
                <label for="anggaran">Anggaran</label>
                <input type="number" name="anggaran" id="anggaran" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>


</x-app-layout>
