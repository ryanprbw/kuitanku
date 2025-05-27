<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Bidang;
use App\Models\DetailBarang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $bidangs = Bidang::all(); // Ambil semua data Bidang
        $barang = Barang::all();
        return view('barang.index', compact('barang', 'bidangs'));
    }

    public function show($id)
    {
        // Mengambil data barang berdasarkan ID dengan relasi detail barang
        $barang = Barang::with('detailBarang')->findOrFail($id);

        // Return ke view detail barang
        return view('barang.show', compact('barang'));
    }

    public function createDetail($barang_id)
    {
        // Ambil data barang berdasarkan ID
        $barang = Barang::findOrFail($barang_id);
        $bidangs = Bidang::all(); // Ambil semua data Bidang
        // Return ke view tambah detail barang
        return view('barang.create-detail', compact('barang', 'bidangs'));
    }
    public function storeDetail(Request $request, $barang_id)
    {
        // Ambil data barang terkait
        $barang = Barang::findOrFail($barang_id);

        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'mutasi_tambah' => 'nullable|integer',
            'mutasi_keluar' => 'nullable|integer',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Ambil harga satuan dari tabel barang
        $validated['harga_satuan'] = $barang->harga_satuan;

        // Hitung Sisa Saldo Barang (Setelah mutasi)
        $validated['sisa_saldo_barang'] = $barang->jumlah + ($validated['mutasi_tambah'] ?? 0) - ($validated['mutasi_keluar'] ?? 0);

        // Hitung Jumlah
        $validated['jumlah'] = ($validated['mutasi_tambah'] ?? 0) - ($validated['mutasi_keluar'] ?? 0);

        // Hitung Nilai Saldo (Jumlah Barang x Harga Satuan)
        $validated['nilai_saldo'] = $validated['sisa_saldo_barang'] * $validated['harga_satuan'];

        // Tambahkan barang_id ke data yang divalidasi
        $validated['barang_id'] = $barang_id;

        // Simpan data detail barang
        DetailBarang::create($validated);

        // Perbarui data barang di tabel barang
        $barang->jumlah = $validated['sisa_saldo_barang'];
        $barang->nilai_saldo = $barang->jumlah * $barang->harga_satuan;
        $barang->save();

        return redirect()->route('barang.show', $barang_id)->with('success', 'Detail barang berhasil ditambahkan.');
    }




    public function create()
    {
        $bidangs = Bidang::all(); // Ambil semua data Bidang
        return view('barang.create', compact('bidangs'));
        // return view('kode_rekening.create', compact('subKegiatans', 'bidangs'));
    }

    public function store(Request $request)
    {
        // dd($request->all());  // Memeriksa data yang diterima
        $validated = $request->validate([
            'bidang_id' => 'required|exists:bidangs,id', // ✅ Tambahkan validasi bidang
            'nama_barang' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'harga_satuan' => 'required|numeric',
            'jumlah' => 'required|integer',
            'keterangan' => 'required|string|max:255',
        ]);

        // Hitung nilai saldo
        $validated['nilai_saldo'] = $validated['jumlah'] * $validated['harga_satuan'];

        Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $bidangs = Bidang::all(); // Ambil semua data Bidang
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang', 'bidangs'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'bidang_id' => 'required|exists:bidangs,id', // ✅ Tambahkan validasi bidang
            'nama_barang' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'harga_satuan' => 'required|numeric',
            'jumlah' => 'required|integer',
            'nilai_saldo' => 'required|numeric',
            'keterangan' => 'required|string|max:255',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function editDetail($barang_id, $detail_id)
    {
        // Ambil data barang dan detail barang berdasarkan ID
        $barang = Barang::findOrFail($barang_id);
        $detailBarang = DetailBarang::findOrFail($detail_id);

        // Mengembalikan view dengan data barang dan detail barang
        return view('barang.edit-detail', compact('barang', 'detailBarang'));
    }


    public function updateDetail(Request $request, $barang_id, $detail_id)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'mutasi_tambah' => 'nullable|integer',
            'mutasi_keluar' => 'nullable|integer',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Ambil data barang dan detail barang
        $barang = Barang::findOrFail($barang_id);
        $detailBarang = DetailBarang::findOrFail($detail_id);

        // Perbarui detail barang
        $detailBarang->update($validated);

        // Update data barang jika ada perubahan
        $barang->jumlah = $barang->jumlah + ($validated['mutasi_tambah'] ?? 0) - ($validated['mutasi_keluar'] ?? 0);
        $barang->nilai_saldo = $barang->jumlah * $barang->harga_satuan;
        $barang->save();

        return redirect()->route('barang.show', $barang_id)->with('success', 'Detail barang berhasil diperbarui.');
    }
    public function destroyDetail($barang_id, $detail_id)
    {
        // Ambil data barang dan detail barang berdasarkan ID
        $barang = Barang::findOrFail($barang_id);
        $detailBarang = DetailBarang::findOrFail($detail_id);

        // Hapus data detail barang
        $detailBarang->delete();

        // Perbarui data barang (jumlah dan nilai saldo)
        $barang->jumlah = $barang->detailBarang->sum('mutasi_tambah') - $barang->detailBarang->sum('mutasi_keluar');
        $barang->nilai_saldo = $barang->jumlah * $barang->harga_satuan;
        $barang->save();

        return redirect()->route('barang.show', $barang_id)->with('success', 'Detail barang berhasil dihapus.');
    }
    public function mutasi(Request $request)
    {
        $barangs = Barang::all();
        $bidangs = Bidang::all();

        $barangId = $request->input('barang_id');
        $bidangId = $request->input('bidang_id');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $detailBarangs = collect();

        if ($barangId || $bidangId || ($tanggalAwal && $tanggalAkhir)) {
            $query = DetailBarang::with(['barang.bidang']);

            if ($barangId) {
                $query->where('barang_id', $barangId);
            }

            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
            }

            if ($bidangId) {
                // Filter berdasarkan bidang dari relasi ke tabel barang
                $query->whereHas('barang', function ($q) use ($bidangId) {
                    $q->where('bidang_id', $bidangId);
                });
            }

            $detailBarangs = $query->orderBy('tanggal')->get();
        }

        return view('barang.mutasi', compact('barangs', 'bidangs', 'detailBarangs', 'barangId', 'bidangId', 'tanggalAwal', 'tanggalAkhir'));
    }



}
