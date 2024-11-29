<!-- resources/views/rincian_belanja_sppd/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Rincian Belanja SPPD') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('rincian_belanja_sppd.update', $rincianSppd->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="nomor_st" class="block text-sm font-medium text-gray-700">{{ __('Nomor ST') }}</label>
                                <input type="text" name="nomor_st" id="nomor_st" value="{{ old('nomor_st', $rincianSppd->nomor_st) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label for="nomor_spd" class="block text-sm font-medium text-gray-700">{{ __('Nomor SPD') }}</label>
                                <input type="text" name="nomor_spd" id="nomor_spd" value="{{ old('nomor_spd', $rincianSppd->nomor_spd) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label for="anggaran" class="block text-sm font-medium text-gray-700">{{ __('Anggaran') }}</label>
                                <input type="number" name="anggaran" id="anggaran" value="{{ old('anggaran', $rincianSppd->anggaran) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>

                            <button type="submit" class="mt-4 btn btn-primary">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
