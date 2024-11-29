<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Bendahara') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('bendahara.update', $bendahara->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" name="nama" id="nama" value="{{ $bendahara->nama }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                            <input type="text" name="nip" id="nip" value="{{ $bendahara->nip }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required maxlength="18" minlength="18" pattern="\d{18}">
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
