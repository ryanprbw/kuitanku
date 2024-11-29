<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PPTK') }}
        </h2>
    </x-slot>
<div class="container">
    <h1>Data PPTK</h1>
    <a href="{{ route('pptks.create') }}" class="btn btn-primary">Tambah PPTK</a>
    <table class="table mt-3">
        <thead>
            <tr>
                
                <th>Nama</th>
                <th>NIP</th>
                <th>Bidang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pptks as $pptk)
                <tr>
                    
                    <td>{{ $pptk->nama }}</td>
                    <td>{{ $pptk->nip }}</td>
                    <td>{{ $pptk->bidang->nama_bidang }}</td>
                    <td>
                        <a href="{{ route('pptks.edit', $pptk->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('pptks.destroy', $pptk->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-app-layout>

