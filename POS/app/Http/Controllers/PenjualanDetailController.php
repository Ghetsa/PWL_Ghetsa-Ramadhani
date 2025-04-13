<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanDetailController extends Controller
{
  public function index()
  {
    // ============================
    // | JOBSHEET 3 - PRAKTIKUM 4 |
    // ============================
    // DB::insert('insert into t_penjualan_detail(penjualan_id, barang_id, jumlah_barang, harga_barang, created_at) values(?, ?, ?, ?, ?)', [11, 11, 7, 180000, now()]);
    // return 'Insert data baru berhasil';

    // $row = DB::update('update t_penjualan_detail set jumlah_barang = ? where detail_id = ?', [3, 12]);
    // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

    // $row = DB::delete('delete from t_penjualan_detail where detail_id = ?', [12]);
    // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

    // $data = DB::select('select * from t_penjualan_detail');
    // return view('penjualan_detail', ['data' => $data]);
  }
}