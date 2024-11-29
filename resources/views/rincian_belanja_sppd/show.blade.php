<!-- resources/views/rincian_belanja_sppd/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Rincian Belanja SPPD') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-4">
                        <p><strong>{{ __('Nomor ST') }}: </strong>{{ $rincianSppd->nomor_st }}</p>
                        <p><strong>{{ __('Nomor SPD') }}: </strong>{{ $rincianSppd->nomor_spd }}</p>
                        <p><strong>{{ __('Anggaran') }}: </strong>{{ number_format($rincianSppd->anggaran, 0, ',', '.') }}</p>
                        <p><strong>{{ __('Tanggal ST') }}: </strong>{{ $rincianSppd->tanggal_st }}</p>
                        <p><strong>{{ __('Tanggal SPD') }}: </strong>{{ $rincianSppd->tanggal_spd }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
