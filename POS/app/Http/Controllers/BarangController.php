<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BarangModel;

class BarangController extends Controller
{
  public function index()
  {
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
        $data = [
          'kategori_id' => 5,
          'barang_kode' => 'ELECT003',
          'barang_nama' => 'Laptop ASUS',
          'harga_beli' => 5000000,
          'harga_jual' => 6500000
      ];
      BarangModel::insert($data);

      $barang = BarangModel::all();
      return view('barang', ['data' => $barang]);

  }
}