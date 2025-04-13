<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
  public function index()
  {
    // ============================
    // | JOBSHEET 3 - PRAKTIKUM 4 |
    // ============================
    // DB::insert('insert into m_kategori(kategori_kode, kategori_nama, created_at) values(?, ?, ?)', ['BPB', 'Barang Pecah Belah', now()]);
    // return 'Insert data baru berhasil';

    // $row = DB::update('update m_kategori set kategori_nama = ? where kategori_kode = ?', ['Pecah Belah', 'BPB']);
    // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

    // $row = DB::delete('delete from m_kategori where kategori_kode = ?', ['BPB']);
    // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

    $data = DB::select('select * from m_kategori');
    return view('kategori', ['data' => $data]);
  }
}
