<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KategoriModel;

class KategoriController extends Controller
{
    // implementasi pos jobsheet 3
    // public function index()
    // {
    // $data = [
    //     'kategori_kode' => 'SNK',
    //     'kategori_nama' => 'Snack/Makanan Ringan',
    //     'created_at' => now()
    // ];
    // DB::table('m_kategori')->insert($data);
    // return 'Insert data baru berhasil';

    // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Camilan']);
    // return "Update data berhasil. Jumlah data yang di update: " . $row.' baris';

    // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
    // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row.' baris';

    // $data = DB::table('m_kategori')->get();
    // return view('kategori', ['data' => $data]);

    // ============================
    // | JOBSHEET 4 - PRAKTIKUM 1 |
    // ============================
    //     $data = [
    //         'kategori_kode' => 'ACC',
    //         'kategori_nama' => 'Aksesoris'
    //     ];
    //     KategoriModel::insert($data);

    //     $kategori = KategoriModel::all();
    //     return view('kategori', ['data' => $kategori]);
    // }

    public function index()
    {
        $kategori = KategoriModel::all(); // ambil semua data dari tabel t_kategori
        return view('kategori', ['data' => $kategori]);
    }

    public function tambah()
    {
        return view('kategori_tambah');
    }

    public function tambah_simpan(Request $request)
    {
        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori');
    }

    public function ubah($id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori_ubah', ['data' => $kategori]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $kategori = KategoriModel::find($id);

        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->kategori_nama = $request->kategori_nama;

        $kategori->save();

        return redirect('/kategori');
    }

    public function hapus($id)
    {
        $kategori = KategoriModel::find($id);
        $kategori->delete();

        return redirect('/kategori');
    }
}