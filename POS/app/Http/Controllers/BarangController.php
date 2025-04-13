<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BarangModel;

class BarangController extends Controller
{
  // public function index()
  // {
  // ============================
  // | JOBSHEET 3 - PRAKTIKUM 4 |
  // ============================
  // DB::insert('insert into m_barang(kategori_id, barang_kode, barang_nama, harga_jual, harga_beli, created_at) values(?, ?, ?, ?, ?, ?)', [1, 'BABY003', 'Dot Bayi', 15000, 10000, now()]);
  // return 'Insert data baru berhasil';

  // $row = DB::update('update m_barang set harga_jual = ? where barang_kode = ?', [17000, 'BABY003']);
  // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

  // $row = DB::delete('delete from m_barang where barang_kode = ?', ['BABY003']);
  // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

  // $data = DB::select('select * from m_barang');
  // return view('barang', ['data' => $data]);


  // ============================
  // | JOBSHEET 4 - PRAKTIKUM 1 |
  // ============================
  //   $data = [
  //     'kategori_id' => 5,
  //     'barang_kode' => 'ELECT003',
  //     'barang_nama' => 'Laptop ASUS',
  //     'harga_beli' => 5000000,
  //     'harga_jual' => 6500000
  // ];
  // BarangModel::insert($data);

  // $barang = BarangModel::all();
  // return view('barang', ['data' => $barang]);

  // }
  public function index()
  {
    $barang = BarangModel::all(); // ambil semua data dari tabel t_barang
    return view('barang', ['data' => $barang]);
  }

  public function tambah()
  {
    return view('barang_tambah');
  }

  public function tambah_simpan(Request $request)
  {
    BarangModel::create([
      'kategori_id' => $request->kategori_id,
      'barang_kode' => $request->barang_kode,
      'barang_nama' => $request->barang_nama,
      'harga_beli' => $request->harga_beli,
      'harga_jual' => $request->harga_jual
    ]);

    return redirect('/barang');
  }

  public function ubah($id)
  {
    $barang = BarangModel::find($id);
    return view('barang_ubah', ['data' => $barang]);
  }

  public function ubah_simpan($id, Request $request)
  {
    $barang = BarangModel::find($id);

    $barang->kategori_id = $request->kategori_id;
    $barang->barang_kode = $request->barang_kode;
    $barang->barang_nama = $request->barang_nama;
    $barang->harga_beli = $request->harga_beli;
    $barang->harga_jual = $request->harga_jual;

    $barang->save();

    return redirect('/barang');
  }

  public function hapus($id)
  {
    $barang = BarangModel::find($id);
    $barang->delete();

    return redirect('/barang');
  }
}