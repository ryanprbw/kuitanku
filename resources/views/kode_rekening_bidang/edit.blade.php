<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kode Rekening Bidang') }}
        </h2>
    </x-slot>


        <div class="container">
            <h1>Edit Kode Rekening Bidang</h1>
    
            <form action="{{ route('kode-rekening-bidang.update', $kodeRekeningBidang->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="kode_rekenings_id">Kode Rekening</label>
                    <select name="kode_rekenings_id" id="kode_rekenings_id" class="form-control">
                        @foreach($kodeRekenings as $kodeRekening)
                            <option value="{{ $kodeRekening->id }}" {{ $kodeRekeningBidang->kode_rekenings_id == $kodeRekening->id ? 'selected' : '' }}>
                                {{ $kodeRekening->nama_kode_rekening }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="bidang_id">Bidang</label>
                    <select name="bidang_id" id="bidang_id" class="form-control">
                        @foreach($bidangs as $bidang)
                            <option value="{{ $bidang->id }}" {{ $kodeRekeningBidang->bidang_id == $bidang->id ? 'selected' : '' }}>
                                {{ $bidang->nama_bidang }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="anggaran">Anggaran</label>
                    <input type="number" name="anggaran" id="anggaran" class="form-control" value="{{ $kodeRekeningBidang->anggaran }}" required>
                </div>
    
                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>
        </div>

    
</x-app-layout>
